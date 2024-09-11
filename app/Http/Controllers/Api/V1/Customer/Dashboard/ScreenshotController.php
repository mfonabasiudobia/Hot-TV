<?php

namespace App\Http\Controllers\Api\V1\Customer\Dashboard;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Customer\Dashboard\ScreenshotResource;
use App\Http\Resources\Api\V1\Customer\Dashboard\WatchListResource;
use Botble\Gallery\Models\Gallery;
use Illuminate\Support\Facades\Auth;

class ScreenshotController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();
        $galleries = Gallery::where('user_id', $user->id)
            ->orderBy('created_at')->paginate(12);

        return response()->json([
            'success' => true,
            'message' => ApiResponseMessageEnum::SCREENSHOTS->value,
            'data' => [
                'galleries' => ScreenshotResource::collection($galleries),
                'pagination' => customPagination($galleries)
            ]
        ]);
    }
}
