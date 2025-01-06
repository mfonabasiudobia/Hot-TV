<?php

namespace App\Http\Resources\Api\V1\Customer\Auth;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthUserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'username' => $this->username,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'email_verified' => !is_null($this->email_verified_at),
            'status' => $this->status,
            'avatar' =>  $this->avatarUrl,
            'subscription' => $this->subscription->subscription->name ?? null,
            'plan' => $this->subscription->subscription->plan->name ?? null,
            'next_billing_date' => $this->subscription->next_billing_date ?? null,
            'subscription_status' => $this->subscription->status ?? null,
        ];
    }
}
