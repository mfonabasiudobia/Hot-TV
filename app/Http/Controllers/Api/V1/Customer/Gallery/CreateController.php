<?php

namespace App\Http\Controllers\Api\V1\Customer\Gallery;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Customer\Gallery\GalleryResource;
use Botble\Gallery\Models\Gallery;
use Botble\Gallery\Models\GalleryMeta;
use Botble\Media\Models\MediaFolder;
use Botble\Media\Models\MediaFile;
use Botble\Base\Enums\BaseStatusEnum;
use Illuminate\Http\Request;
use AppHelper;

class CreateController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            "uploadedFiles" => "required",
            "ride_id"   =>  "required|exists:rides,id"
        ]);

        $user = auth('api')->user();
        $path = "appuploads/{$user->id}";
        $rideId = $request->ride_id;

        $uploadsFolder = MediaFolder::updateOrCreate([
            'slug' => 'appuploads'
        ], [
            'name' => 'appuploads',
            'user_id' => 0,
            'parent_id' => 0,
        ]);

        $userFolder = MediaFolder::updateOrCreate([
            'slug' => "appuploads-ride-{$rideId}"
        ], [
            'name' => $user->id,
            'user_id' => 0,
            'parent_id' => $uploadsFolder->id,
        ]);

        $gallery = Gallery::where('user_id', $user->id)->where('ride_id', $rideId)->first();

        if(! $gallery) {
            $uploadedImage = upload_gallery_file($request->uploadedFiles[0], $path);
            $gallery = Gallery::create([
                'name' => $request->title,
                'description' => $request->description,
                'is_featured' => 0,
                'image' => $uploadedImage['file_path'],
                'order' => 1,
                'user_id' => $user->id,
                'ride_id' => $rideId,
                'status' => BaseStatusEnum::PENDING()->getValue()
            ]);
        }

        foreach($request->uploadedFiles as $image){
            $uploadedImage = upload_gallery_file($image, $path);
            $mediaImages[] = [
                'img' => $uploadedImage['file_path'],
                'description' => $uploadedImage['name']
            ];

            MediaFile::create([
                'user_id' => $user->id,
                'name' => MediaFile::createName($uploadedImage['name'], $userFolder->id),
                'alt' => $request->title,
                'folder_id' => $userFolder->id,
                'mime_type' => $uploadedImage['mime_type'],
                'size' => $uploadedImage['size'],
                'url' => $uploadedImage['file_path'],
                'type' => 'external'
            ]);
        }

        GalleryMeta::create([
            'images' => $mediaImages,
            'reference_id' => $gallery->id,
            'reference_type' => 'Botble\Gallery\Models\Gallery'
        ]);

        return response()->json([
            'success' => true,
            'message' => ApiResponseMessageEnum::GALLERY->value,
            'data' => [
                'gallery' => new GalleryResource($gallery),
            ]
        ]);
    }
}
