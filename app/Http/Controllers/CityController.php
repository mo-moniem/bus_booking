<?php

namespace App\Http\Controllers;

use App\Http\Resources\CityResource;
use App\Models\City;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CityController extends Controller
{

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request):JsonResponse{
        $cities = CityResource::collection(City::ofName($request['search'])->get());
        return  response()->json(['status'=>true,'data'=>$cities]);
    }
}
