<?php

namespace App\Http\Controllers\Api\V1\Customer\Dashboard;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Customer\Dashboard\WatchListResource;
use App\Models\TvShow;
use App\Models\Watchlist;
use Illuminate\Support\Facades\Auth;

class WatchListController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();
        $watchLists = Watchlist::where('user_id', $user->id)->where('watchable_type', TvShow::class)->paginate(12);
        return response()->json([
            'success' => true,
            'message' => ApiResponseMessageEnum::WATCH_LISTS->value,
            'data' => [
                'tv_shows' => WatchListResource::collection($watchLists),
                'pagination' => customPagination($watchLists)
            ]
        ]);
    }
}
