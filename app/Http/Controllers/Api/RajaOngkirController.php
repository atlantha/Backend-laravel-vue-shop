<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Province;
use Kavist\RajaOngkir\Facades\RajaOngkir;


class RajaOngkirController extends Controller
{
    public function getProvinces(){
        $provinces = Province::all();
        return response()->json([
            'success'       => true,
            'message'       => 'list data province',
            'data'          => $provinces
        ]);
    }

    public function getCities(Request $request){
        $city = City::where('province_id', $request->province_id)->get();
        return response()->json([
            'success'   => true,
            'message'   => 'list data cities by province',
            'data'      => $city
        ]);
    }

    public function checkOngkir(Request $request){
        $cost = RajaOngkir::ongkosKirim([
            'origin'        => 113,
            'destination'   => $request->city_destination,
            'weight'        => $request->weight,
            'coourier'      => $request->courier
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'list data cost all courir'.$request->courier,
            'data'      => $cost
        ]);
    }
}
