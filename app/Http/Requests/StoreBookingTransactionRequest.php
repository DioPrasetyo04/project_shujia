<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'post_code' => 'required|string|max:255',
            'started_time' => 'required|date_format:H:i',
            'proof' => 'required|file|mimes:jpg,jpeg,png,webp|max:2048',
            // fitur keranjang belanja harus berupa array
            'service_ids' => 'required|array',
            // fitur keranjang belanja harus berupa integer per item yang ngambil dari TransactionDetails->homeService
            'service_ids.*' => 'integer|exists:home_services,id',
            'schedule_at' => 'date_format:Y-m-d',
        ];
    }
}
