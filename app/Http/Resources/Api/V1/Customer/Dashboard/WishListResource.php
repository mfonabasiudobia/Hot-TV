<?php

namespace App\Http\Resources\Api\V1\Customer\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class WishListResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'slug' => $this->product->slug,
            'thumbnail' => file_path($this->product->images[0]),
            'category' => $this->product->categories[0]->name,
            'name' => $this->product->name,
            'price' => ac() . number_format($this->product->price),
        ];
    }
}
