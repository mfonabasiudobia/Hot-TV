<?php

namespace App\Http\Resources\Api\V1\Customer\Ecommerce;

use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "description" => $this->description,
            "website" => $this->website,
            "logo" => $this->logo,
        ];
    }
}
