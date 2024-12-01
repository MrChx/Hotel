<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CityResource;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::withCount('hotelSpaces')->get();
        return CityResource::collection($cities);
    }

    public function show(City $city)
    {
        $city->load(['hotelSpaces.city', 'hotelSpaces.photos']);
        $city->loadCount('hotelSpaces');
        return new CityResource($city);
    }
}
