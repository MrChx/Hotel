<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use IlLuminate\Support\Str;

class BookingTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'phone_number',
        'booking_trx_id',
        'is_paid',
        'started_at',
        'total_amount',
        'duration',
        'ended_at',
        'hotel_space_id',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = str::slug($value);
    }

    public static function generateUniqueTrxId()
    {
        $prefix = '';
        do {
            $randomString = $prefix . mt_rand(1000, 9999);
        } while (self::where('booking_trx_id', $randomString)->exists());

        return $randomString;
    }

    public function hotelSpace(): BelongsTo
    {
        return $this->belongsTo(HotelSpace::class);
    }
}
