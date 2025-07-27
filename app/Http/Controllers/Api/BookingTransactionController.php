<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\BookingTransactionService;
use App\Http\Requests\StoreBookingTransactionRequest;

class BookingTransactionController extends Controller
{
    protected $bookingTransaction;
    public function __construct(
        BookingTransactionService $bookingTransactionService
    ) {
        $this->bookingTransaction = $bookingTransactionService;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookingTransactionRequest $request)
    {
        try {
            return $this->bookingTransaction->StoreData($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create booking transaction',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function booking_details(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'booking_trx_id' => 'required|string'
        ]);
        return $this->bookingTransaction->bookingDetails($request);
    }
}
