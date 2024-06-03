<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\City;
class CityController extends Controller
{
    public function showByRegion($region_id)
    {

        $validator = Validator::make(['region_id' => $region_id], [
            'region_id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => 'El ID de la región debe ser un valor numérico.'], 400);
        }
        $cities = City::where('region_id', $region_id)
                      ->where('status', 1)
                      ->orderBy('name', 'asc')
                       ->get();
        return response()->json($cities);
    }
}
