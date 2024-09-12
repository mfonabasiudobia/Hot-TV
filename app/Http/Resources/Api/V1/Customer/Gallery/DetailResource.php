<?php

namespace App\Http\Resources\Api\V1\Customer\Gallery;

use Botble\Gallery\Models\GalleryMeta;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailResource extends JsonResource
{
    public function toArray($request)
    {
        $gallery = GalleryMeta::where('reference_id', $this->id)->first();
        if(!isset($gallery->images)) {
            return [];
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'user_avatar' => $this->user->avatarUrl,
            'user_name' => $this->user->name,
            'description' => $this->description,
            'gallery' => isset($gallery->images) ? collect($gallery->images)->map(function($item) {
                return asset( 'storage/' . $item['img']);
            }) : null
        ];
    }
}
