<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    public function search(Request $request)
    {
        $searchId = $request->id;

        if(!$searchId) {
            return response()->json([
                'message' => 'Parameter id is required'
            ], 400);
        }

        $province = Province::find($searchId);

        if(!$province) {
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
