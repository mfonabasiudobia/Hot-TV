<?php

namespace App\Http\Controllers\Api\V1\Customer\Dashboard;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Customer\Dashboard\WatchHistoryResource;
use App\Models\TvShowView;
use Illuminate\Support\Facades\Auth;

class WatchHistoryController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();
        $tvShows = TvShowView::where('user_id', $user->id)->groupBy('tv_show_id')->selectRaw('tv_show_views.tv_show_id, tv_show_views.id')->paginate(12);

        return response()->json([
            'success' => true,
            'message' => ApiResponseMessageEnum::WATCH_HISTORY->value,
            'data' => [
                'watch-histories' => WatchHistoryResource::collection($tvShows),
                'pagination' => customPagination($tvShows)
            ]
        ]);

    }
}
