<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Adress;
use App\Services\GeoAdress;
use Illuminate\Http\Request;

class GeoController extends Controller
{
    public function coordinatesToAdress(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-180,180',
            'longitude' => 'required|numeric||between:-90,90',
        ]);

        $coordinates = $request->only(['latitude', 'longitude']);
        $geo = new GeoAdress($coordinates['latitude'], $coordinates['longitude']);
        $adress = $geo->getAdress();

        return $adress;
    }

    public function adresses()
    {
        $adresses = Adress::get();

        return $adresses;
    }

    public function adressByPlaceId(Request $request)
    {
        $request->validate([
            'place_id' => 'required|numeric',
        ]);
        $place_id = $request->only('place_id')['place_id'];

        $adresses = Adress::select('adress')
            ->whereHas('places', function($query) use($place_id){
                $query->where('places.id', $place_id);
            })->get();

        return $adresses;
    }
    
}
