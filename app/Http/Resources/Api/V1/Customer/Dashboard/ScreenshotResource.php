<?php

namespace App\Http\Resources\Api\V1\Customer\Dashboard;

use Botble\Gallery\Models\GalleryMeta;
use Illuminate\Http\Resources\Json\JsonResource;

class ScreenshotResource extends JsonResource
{
    public function toArray($request)
    {
        $gallery = GalleryMeta::where('reference_id', $this->id)->first();

       return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'description' => $this->description,
            'gallery' => isset($gallery->images) ? collect($gallery->images)->map(function($item) {
                $img = explode('.', $item['img']);
                $slideshowImage = $img[0] . '-150x150.'. $img[1];
                return asset( 'storage/' . $slideshowImage);
            }) : null
       ];
    }
}
