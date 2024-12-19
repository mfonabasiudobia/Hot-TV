<?php

namespace App\Http\Controllers\Api\V1\Driver\Ride;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DriverStatusController extends Controller
{
    public function setOnline(Request $request)
    {
        $request->validate([
            "online_status"=> "required",
            "latitude"=> "required",
            "longitude"=> "required",
        ]);

        $user = $request->user();
        $user->online_status = true;
        $user->latitude = $request->latitude;
        $user->longitude = $request->longitude;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => ApiResponseMessageEnum::SET_ONLINE->value,
        ]);
    }

    public function setOffline(Request $request)
    {
        $user = $request->user();
        $user->online_status = true;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => ApiResponseMessageEnum::SET_ONLINE->value,
        ]);
    }
}
