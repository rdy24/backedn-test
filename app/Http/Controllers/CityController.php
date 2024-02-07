<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function search(Request $request)
    {
        $searchId = $request->id;

        if(!$searchId) {
            return response()->json([
                'message' => 'Parameter id is required'
            ], 400);
        }

        $city = City::find($searchId);

        if(!$city) {
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
