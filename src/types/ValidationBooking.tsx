import { z } from "zod";

export const bookingSchema = z.object({
    name: z.string().min(1, "name is required"),
    phone_number: z.string().min(1, "phone number is required"),
    started_at: z.string().refine((date) => !isNaN(Date.parse(date)), "invalid date"),
    hotel_space_id: z.number().min(1, "hotel is required"),
});

export const viewBookingSchema = z.object({
    booking_trx_id: z.string().min(1, "Booking trx is required"),
    phone_number: z.string().min(1, "phone number is required"),
})