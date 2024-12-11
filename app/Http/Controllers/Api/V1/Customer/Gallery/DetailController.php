<?php

namespace App\Http\Controllers\Api\V1\Customer\Gallery;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Customer\Gallery\DetailResource;
use Botble\Gallery\Models\Gallery;

class DetailController extends Controller
{
    public function __invoke(Gallery $gallery)
    {
        return response()->json([
            'success' => true,
            'message' => ApiResponseMessageEnum::GALLERY->value,
            'data' => new DetailResource($gallery),


        ]);
    }
}
