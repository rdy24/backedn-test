<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Services\RajaOngkirService;
use Illuminate\Http\Request;

class CityController extends Controller
{
    protected $rajaOngkirService;

    public function __construct(RajaOngkirService $rajaOngkirService)
    {
        $this->rajaOngkirService = $rajaOngkirService;
    }
    
    public function search(Request $request)
    {
        $searchId = $request->id;

        if(!$searchId) {
            return response()->json([
                'message' => 'Parameter id is required'
            ], 400);
        }

        $city = City::find($searchId);

        if (config('app.search_provider') === 'rajaongkir') {
            $city = $this->rajaOngkirService->getCityById($searchId);
        }

        if (!$city || (config('app.search_provider') === 'rajaongkir' && empty($city['rajaongkir']['results']))) {
            return response()->json([
                'message' => 'Data not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Data found',
            'data' => $city
        ], 200);
    }
}
