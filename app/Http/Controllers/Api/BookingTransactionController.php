<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\storeBookingTransactionRequest;
use App\Http\Resources\Api\BookingTransactionResource;
use App\Models\BookingTransaction;
use App\Models\HotelSpace;
use Illuminate\Http\Request;

class BookingTransactionController extends Controller
{
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
