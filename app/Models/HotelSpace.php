<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use IlLuminate\Support\Str;

class HotelSpace extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'thumbnail',
        'is_open',
        'is_full_booked',
        'price',
        'duration',
        'address',
        'about',
        'slug',
        'city_id',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = str::slug($value);
    }
    public function photos(): HasMany
    {
        return $this->hasMany(HotelSpacePhoto::class);
    }

    public function benefits(): HasMany
    {
        return $this->hasMany(HotelSpaceBenefit::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
