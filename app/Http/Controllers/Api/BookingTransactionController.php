<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\storeBookingTransactionRequest;
use App\Http\Resources\Api\BookingTransactionResource;
use App\Http\Resources\Api\ViewBookingResource;
use App\Models\BookingTransaction;
use App\Models\HotelSpace;
use Illuminate\Http\Request;

class BookingTransactionController extends Controller
{
    public function booking_details(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string',
            'booking_trx_id' => 'required|string',
        ]);

        $booking = BookingTransaction::where('phone_number', $request->phone_number)
                ->where('booking_trx_id', $request->booking_trx_id)
                ->with(['hotelSpace', 'hotelSpace.city'])
                ->first();
        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }
        return new ViewBookingResource($booking);
    }

    public function store(StoreBookingTransactionRequest $request)
    {
        $validatedData = $request->validated();
        $hotelSpace = HotelSpace::find($validatedData['hotel_space_id']);

        $validatedData['is_paid'] = false;
        $validatedData['booking_trx_id'] = BookingTransaction::generateUniqueTrxId();
        $validatedData['duration'] = $hotelSpace->duration;

        $validatedData['ended_at'] = (new \DateTime($validatedData['started_at']))
        ->modify("+{$hotelSpace->duration} days")->format('Y-m-d');
    
        $bookingTransaction = BookingTransaction::create($validatedData);
        $bookingTransaction->load('hotelSpace');
        return new BookingTransactionResource($bookingTransaction);

    }
}
