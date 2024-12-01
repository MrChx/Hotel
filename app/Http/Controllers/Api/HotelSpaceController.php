<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\HotelSpaceResource;
use App\Models\HotelSpace;
use Illuminate\Http\Request;

class HotelSpaceController extends Controller
{
    public function index()
    {
        $hotelSpaces = HotelSpace::with('city')->get();
        return HotelSpaceResource::collection($hotelSpaces);
    }

    public function show(HotelSpace $hotelSpace)
    {
        $hotelSpace->load(['city', 'photos', 'benefits']);
        return new HotelSpaceResource($hotelSpace);
    }
}
