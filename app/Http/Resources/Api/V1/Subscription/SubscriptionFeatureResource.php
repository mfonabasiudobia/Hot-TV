<?php

namespace App\Http\Resources\Api\V1\Subscription;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionFeatureResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description
        ];
    }
}
