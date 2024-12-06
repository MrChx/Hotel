<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeBookingTransactionRequest extends FormRequest
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
            'phone_number' => 'required|string|max:255',
            'started_at' => 'required|date',
            'hotel_space_id' => 'required|exists:hotel_spaces,id', // Pastikan ID valid
            'total_amount' => 'required|integer|min:1',
        ];
    }
}
