<?php

namespace App\Http\Resources\Api\V1\Customer\Subscription;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'features' => SubscriptionFeatureResource::collection($this->features)
        ];
    }
}
