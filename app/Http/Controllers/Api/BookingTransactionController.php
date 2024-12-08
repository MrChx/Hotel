<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\storeBookingTransactionRequest;
use App\Http\Resources\Api\BookingTransactionResource;
use App\Http\Resources\Api\ViewBookingResource;
use App\Models\BookingTransaction;
use App\Models\HotelSpace;
use Illuminate\Http\Request;
use Twilio\Rest\Client;

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

        $sid = getenv("TWILIO_ACCOUNT_SID");
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio = new Client($sid, $token);

        $messageBody = "Halo Admin, ada yang pesan hotel di {$bookingTransaction->hotelSpace->name} nih.\n\n";
        $messageBody.= "Dengan nama {$bookingTransaction->name}, nomor hp {$bookingTransaction->phone_number}, dan nomor Pesan {$bookingTransaction->booking_trx_id}\n\n";
        $messageBody.= "Segera cek CMS dan terima pesanannya.";

        $message = $twilio->messages->create(
            "+6285256676036",
            [
                "body" => $messageBody,
                "from" => getenv("TWILIO_PHONE_NUMBER"),
            ]
            );

        $bookingTransaction->load('hotelSpace');
        return new BookingTransactionResource($bookingTransaction);

    }
}
