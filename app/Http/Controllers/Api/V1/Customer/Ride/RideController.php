<?php

namespace App\Http\Controllers\Api\V1\Customer\Ride;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
use App\Models\Ride;
use Illuminate\Http\Request;
use App\Services\AgoraDynamicKey\RtcTokenBuilder\RtcTokenBuilder;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\Api\V1\Customer\Ride\StreamResource;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class RideController extends Controller
{
    public function ongoing(Request $request)
    {
        $streams = Ride::where('user_id', $request->user()->id)
            ->whereIn('status', ['started', 'requested'])
            ->with(['customer']);

        return response()->json([
            'success' => true,
            'message' => ApiResponseMessageEnum::STREAM_LIST->value,
            'data' => [
                'ride' => $ride
            ]
        ]);
    }
}
