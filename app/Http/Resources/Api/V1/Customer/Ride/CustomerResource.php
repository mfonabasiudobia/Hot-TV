<?php

namespace App\Http\Resources\Api\V1\Customer\Ride;

use Botble\ACL\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 */
class CustomerResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'dob' => $this->dob,
            'description' => $this->description,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'online_status' => $this->online_status,
            'username' => $this->username,
            'name' => $this->name,
            'status' => $this->status,
        ];
    }
}
