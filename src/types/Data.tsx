export interface Hotel {
    id: number,
    price: number,
    duration: number,
    name: string,
    slug: string,
    city: City,
    address: string,
    thumbnail: string,
    photos: Photo[],
    benefits: Benefit[],
    about: string,
}

interface Photo {
    id: number,
    photo: string,
}

interface Benefit {
    id: number,
    name: string,
}

export interface City {
    id: number;
    name: string;
    slug: string;
    photo: string;
    hotelSpaces_count: number;
    hotelSpaces: Hotel[];
}

export interface BookingDetails {
    id: number;
    name: string;
    phone_number: string;
    booking_trx_id: string;
    is_paid: boolean;
    duration: number;
    total_amount: number;
    started_at: string;
    ended_at: string;
    hotel: Hotel;
}