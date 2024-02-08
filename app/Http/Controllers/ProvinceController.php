<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Services\RajaOngkirService;
use Illuminate\Http\Request;

class ProvinceController extends Controller
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

        $province = Province::find($searchId);

        if (config('app.search_provider') === 'rajaongkir') {
            $province = $this->rajaOngkirService->getProvinceById($searchId);
        }

        if (!$province || (config('app.search_provider') === 'rajaongkir' && empty($province['rajaongkir']['results']))) {
            return response()->json([
                'message' => 'Data not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Data found',
            'data' => $province
        ], 200);
    }
}