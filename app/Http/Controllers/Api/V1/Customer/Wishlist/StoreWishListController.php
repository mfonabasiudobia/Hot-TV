<?php

namespace App\Http\Controllers\Api\V1\Customer\Wishlist;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
use App\Models\Watchlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreWishListController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'type' => 'required|in:tvshow,stream,podcast'
        ]);

        $user = Auth::user();

        $types = [
            'tvshow' => 'App\Models\Tvshow',
            'stream' => 'App\Models\Ride',
            'podcast' => 'App\Models\Podcast',
        ];

        $data = [
            'user_id' => $user->id,
            'watchable_id' => $request->id,
            'watchable_type' => $types[$request->type]
        ];

        $watchlist = Watchlist::create($data);

        return response()->json([
            'success' => true,
            'message' => ApiResponseMessageEnum::WISH_LISTS->value,
            'data' => [
                'watchlist' => $watchlist
            ]
        ]);
    }
}
