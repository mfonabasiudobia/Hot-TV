<?php

namespace App\Http\Resources\Api\V1\Customer\Gallery;

use Botble\Gallery\Models\GalleryMeta;
use Illuminate\Http\Resources\Json\JsonResource;

class GalleryResource extends JsonResource
{
    public function toArray($request)
    {
        $galleryMeta = GalleryMeta::where('reference_id', $this->id)->first();
        if(!$galleryMeta) {
         return [];
        }

        $image = $galleryMeta->images[0];
        $img = explode('.', $image['img']);
        $slideshowImage = $img[0] . '-150x150.'. $img[1];

        return [
            'id' => $this->id,
            'thumbnail' => asset( 'storage/' . $slideshowImage),
            'name' => $this->name,
            'user_avatar' => $this->user->avatarUrl,
            'user_name' => $this->user->name
        ];
    }
}
