<?php

namespace App\Http\Resources\Api\V1\Customer\Subscription;

use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'subscriptions' => SubscriptionResource::collection($this->subscriptions)
        ];
    }
}
