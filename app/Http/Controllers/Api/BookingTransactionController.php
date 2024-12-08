<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingTransactionRequest;
use App\Http\Resources\Api\BookingTransactionResource;
use App\Http\Resources\Api\ViewBookingResource;
use App\Models\BookingTransaction;
use App\Models\HotelSpace;
use DateTime;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Twilio\Exceptions\TwilioException;

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
        try {
            $validatedData = $request->validated();
            
            // Find Hotel Space
            $hotelSpace = HotelSpace::findOrFail($validatedData['hotel_space_id']);

            // Prepare Booking Transaction Data
            $validatedData['is_paid'] = false;
            $validatedData['booking_trx_id'] = $this->generateUniqueBookingId();
            $validatedData['duration'] = $hotelSpace->duration;

            // Calculate End Date
            $validatedData['ended_at'] = (new DateTime($validatedData['started_at']))
                ->modify("+{$hotelSpace->duration} days")
                ->format('Y-m-d');
        
            // Create Booking Transaction
            $bookingTransaction = BookingTransaction::create($validatedData);

            // Send Twilio Notification (Optional)
            $this->sendTwilioNotification($bookingTransaction);

            // Load Related Data
            $bookingTransaction->load('hotelSpace');

            return new BookingTransactionResource($bookingTransaction);

        } catch (\Exception $e) {
            Log::error('Booking Transaction Error: ' . $e->getMessage(), [
                'data' => $validatedData ?? [],
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'message' => 'Error creating booking transaction',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function generateUniqueBookingId()
    {
        do {
            $bookingTrxId = 'BK-' . strtoupper(substr(uniqid(), -6));
        } while (BookingTransaction::where('booking_trx_id', $bookingTrxId)->exists());

        return $bookingTrxId;
    }

    private function sendTwilioNotification($bookingTransaction)
    {
        try {
            $sid = config('services.twilio.sid');
            $token = config('services.twilio.token');
            $twilioNumber = config('services.twilio.number');
            $adminNumber = config('services.twilio.admin_number');

            if (!$sid || !$token || !$twilioNumber || !$adminNumber) {
                Log::warning('Incomplete Twilio configuration');
                return;
            }

            $twilio = new Client($sid, $token);

            $messageBody = "Halo Admin, ada yang pesan hotel di {$bookingTransaction->hotelSpace->name} nih.\n\n";
            $messageBody .= "Dengan nama {$bookingTransaction->name}, nomor hp {$bookingTransaction->phone_number}, dan nomor Pesan {$bookingTransaction->booking_trx_id}\n\n";
            $messageBody .= "Segera cek CMS dan terima pesanannya.";

            $twilio->messages->create($adminNumber, [
                'from' => $twilioNumber,
                'body' => $messageBody
            ]);

        } catch (TwilioException $e) {
            Log::error('Twilio SMS Error: ' . $e->getMessage());
        }
    }
}