<?php

namespace App\Http\Controllers\Api\V1\Customer\Gallery;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Customer\Gallery\GalleryResource;
use Botble\Gallery\Models\Gallery;

class ListController extends Controller
{
    public function __invoke()
    {
        $photoGallery = Gallery::where('user_id', '!=', 1)
            ->where('status', \Botble\Base\Enums\BaseStatusEnum::PUBLISHED()->getValue())
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'message' => ApiResponseMessageEnum::GALLERY->value,
            'data' => [
                'galleries' => GalleryResource::collection($photoGallery),
                'pagination' => customPagination($photoGallery)
            ]
        ]);

    }
}
