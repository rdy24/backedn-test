<?php 
// app/Services/RajaOngkirService.php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RajaOngkirService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('RAJAONGKIR_API_KEY');
        $this->baseUrl = 'https://api.rajaongkir.com/starter';
    }

    public function getProvinces()
    {
        $response = Http::withHeaders([
            'key' => $this->apiKey
        ])->get($this->baseUrl.'/province');

        return $response->json();
    }

    public function getProvinceById($provinceId)
    {
        $response = Http::withHeaders([
            'key' => $this->apiKey
        ])->get($this->baseUrl.'/province', [
            'id' => $provinceId
        ]);

        return $response->json();
    }

    public function getCities()
    {
        $response = Http::withHeaders([
            'key' => $this->apiKey
        ])->get($this->baseUrl.'/city');

        return $response->json();
    }

    public function getCityById($cityId)
    {
        $response = Http::withHeaders([
            'key' => $this->apiKey
        ])->get($this->baseUrl.'/city', [
            'id' => $cityId
        ]);

        return $response->json();
    }
}
