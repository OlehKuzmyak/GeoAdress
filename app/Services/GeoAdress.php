<?php

namespace App\Services;

use App\Models\Adress;
use App\Models\Place;
use App\Models\Type;
use Illuminate\Support\Facades\Http;

class GeoAdress
{
    private float $latitude;
    private float $longitude;
    private $response;

    public function __construct(float $latitude, float $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;

        $this->response = $this->makeRequest();
        $this->storeToDB();
    }

    public function getAdress()
    {
        return $this->response['results'][0]['formatted_address'];
    }

    private function makeRequest()
    {
        $domain = config('geocoding.domain');

        $response = Http::get($domain, [
            'address' => "$this->latitude, $this->longitude",
            'key' => config('geocoding.api_key'),
        ])->json();

        return $response;
    }

    private function storeToDB()
    {
        $adress = Adress::firstOrCreate([
            'latitude' => $this->latitude, 
            'longtitude' => $this->longitude, 
            'adress' => $this->getAdress(),
            ]);

        $components = $this->response['results'][0]['address_components'];
        $components = array_reverse($components);

        foreach($components as $component)
        {
            $place = Place::firstOrCreate([
                'place' => $component['long_name'], 
                ]);
            $adress->places()->attach($place);

            foreach($component['types'] as $type)
            {
                $type = Type::firstOrCreate(['type' => $component['long_name']]);
                $place->types()->attach($type);
            }
        }
    }
}