<?php


namespace App\Services;

use Carbon\Carbon;
use App\Models\HomeService;
use App\Models\BookingTransaction;
use App\Http\Resources\Api\BookingTransactionApiResource;

class BookingTransactionService
{

    public function StoreData($request)
    {
        $validatedData = $request->validated();
        if ($request->hasFile('proof')) {
            $filePath = $request->file('proof')->store('proofs', 'public');
            $validatedData['proof'] = $filePath;
        }

        $serviceIds = $request->input('service_ids');

        if (empty($serviceIds)) {
            return response()->json(['error' => 'No Service Selected.'], 400);
        }

        $services = HomeService::whereIn('id', $serviceIds)->get();

        if (empty($services)) {
            return response()->json(['error' => 'Invalid Services.'], 400);
        }

        // karena banyak services yang dipilih maka semua harga di kalkulasi sum
        $totalPrice = $services->sum('price');
        $tax = $totalPrice * 0.11;
        $grandTotal = $totalPrice + $tax;

        $validatedData['schedule_at'] = $request->schedule_at ?? Carbon::now()->addDays(1)->toDateString();

        $max_booking_schedule_at = 5;
        $count_booking_schedule_at = BookingTransaction::where('schedule_at', $validatedData['schedule_at'])->count();
        // checking schedule_at apakah sudah ada yang booking tanggal segitu jika sudah ada kirim notifikasi sudah ada yang booking
        if ($count_booking_schedule_at >= $max_booking_schedule_at) {
            return response()->json([
                'message' => 'Booking all fully booked',
                'available_slots' => 0,
                'max_booking_target_per_day' => $max_booking_schedule_at,
                'current_bookings' => $count_booking_schedule_at
            ], 400);
        }

        $available_slots = $max_booking_schedule_at - $count_booking_schedule_at;
        $validatedData['available_slots'] = $available_slots;
        $validatedData['sub_total'] = $totalPrice;
        $validatedData['total_tax_amount'] = $tax;
        $validatedData['total_amount'] = $grandTotal;
        $validatedData['is_paid'] = false;
        $validatedData['booking_trx_id'] = BookingTransaction::generateUniqueTrxId();

        $bookingTransaction = BookingTransaction::create($validatedData);

        if (!$bookingTransaction) {
            return response()->json(['error' => 'Failed to create Booking Transaction.'], 500);
        }

        foreach ($services as $service) {
            $bookingTransaction->transactionDetails()->create([
                'home_service_id' => $service->id,
                'price' => $service->price
            ]);
        }

        return new BookingTransactionApiResource($bookingTransaction->load('transactionDetails'));
    }

    public function bookingDetails($request)
    {
        $booking = BookingTransaction::where('email', $request->email)
            ->where('booking_trx_id', $request->booking_trx_id)
            ->with([
                'transactionDetails',
                'transactionDetails.homeService'
            ])->first();

        if (!$booking) {
            return response()->json([
                'message' => 'Booking transaction not found'
            ], 404);
        }

        return new BookingTransactionApiResource($booking);
    }
}
