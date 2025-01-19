<?php

namespace App\Http\Controllers\Api\V1\Customer\TvShow;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
use App\Models\TvShow;
use App\Models\TvShowView;
use Illuminate\Http\Request;

class StoreWatchListController extends Controller
{
    public function __invoke($showId, Request $request)
    {
        $show = TvShow::find($showId);
        if(!$show) {
            return response()->json([
                'success' => false,
                'message' => ApiResponseMessageEnum::NOT_FOUND->value,
            ]);
        }

        $request->validate([
            'episode_id' => 'exists:episodes,id',
            'season_id' => 'exists:seasons,id',
        ]);

        $seasonId = $request->season_id;
        $episodeId = $request->episode_id;

        $tvShowViews = TvShowView::where('user_id',  auth()->id())
            ->where('ip_address',  request()->ip())
            ->where('tv_show_id', $showId)
            ->first();

        if(!$tvShowViews) {
            $tvShowViews = TvShowView::create([
                'user_id' => auth('api')->id(),
                'ip_address' => request()->ip(),
                'tv_show_id' => $showId,
                'episode_id' => $episodeId,
                'season' => $seasonId
            ]);
        } else {
            if($tvShowViews->episode_id == null) {
                $tvShowViews->episode_id = $episodeId;
                $tvShowViews->season = $seasonId;
                $tvShowViews->save();
            }
        }

        return response()->json([
            'success' => true,
            'message' => ApiResponseMessageEnum::WATCH_LISTS->value,
            'data' => [
                'tvshow_view' => $tvShowViews
            ]
        ]);
    }
}
