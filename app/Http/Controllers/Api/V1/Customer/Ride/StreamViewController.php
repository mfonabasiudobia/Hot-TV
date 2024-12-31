<?php

namespace App\Http\Controllers\Api\V1\Customer\Ride;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Events\LocationUpdated;
use App\Http\Controllers\Controller;
use App\Models\PedicabStreamView;
use App\Models\Ride;
use Botble\ACL\Models\User;
use Illuminate\Http\Request;

class StreamViewController extends Controller
{
    public $ip;
    public function __construct()
    {
        $this->ip = request()->ip() ?? '127.0.0.1';
    }
    public function joined(Ride $ride)
    {
        try {
            $user = auth('api')->user();
            $streamView = PedicabStreamView::where('user_id',  $user->id)
                ->where('ip_address',  $this->ip)
                ->where('ride_id', $ride->id)
                ->first();

            if (!$streamView) {

                PedicabStreamView::create([
                    'user_id'=> $user->id,
                    'ride_id'=> $ride->id,
                    'status' => 'watching',
                    'ip_address' => $this->ip
                ]);

            } else {
                $streamView->status = 'watching';
                $streamView->save();
            }

            $totalWatching = PedicabStreamView::where('ride_id', $ride->id)->where('status', 'wathing')->count();
            $totalViews = PedicabStreamView::where('ride_id', $ride->id)->count();

            // broadcast event of updates to show on mobile apps if required

            return response()->json([
                'success' => true,
                'message' => ApiResponseMessageEnum::STREAM_JOINED_SUCCESS->value,
                'data' => [
                    'views' => $totalViews,
                    'watching' => $totalWatching
                ]
            ]);
        } catch (\Throwable $th) {
            app_log_exception($th);

            return response()->json([
                'success' => false,
                'message' => ApiResponseMessageEnum::SERVER_ERROR->value,
                'error' => $th->getMessage()
            ]);
        }
    }

    public function left(Ride $ride)
    {
        try {
            $user = auth('api')->user();

            $streamView = PedicabStreamView::where('user_id',  $user->id)
                ->where('ip_address',  $this->ip)
                ->where('ride_id', $ride->id)
                ->first();

            if ($streamView) {
                $streamView->status = 'left';
                $streamView->save();
            }

            $totalWatching = PedicabStreamView::where('ride_id', $ride->id)->where('status', 'wathing')->count();
            $totalViews = PedicabStreamView::where('ride_id', $ride->id)->count();

            // broadcast event of updates to show on mobile apps if required

            return response()->json([
                'success' => true,
                'message' => ApiResponseMessageEnum::STREAM_LEFT_SUCCESS->value,
                'data' => [
                    'views' => $totalViews,
                    'watching' => $totalWatching
                ]
            ]);
        } catch (\Throwable $th) {
            app_log_exception($th);

            return response()->json([
                'success' => false,
                'message' => ApiResponseMessageEnum::SERVER_ERROR->value,
                'error' => $th->getMessage()
            ]);
        }
    }
}
