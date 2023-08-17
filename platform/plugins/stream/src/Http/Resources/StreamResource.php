<?php

namespace Botble\Stream\Http\Resources;

use Botble\Stream\Models\Stream;
use Botble\Media\Facades\RvMedia;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Post
 */
class StreamResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'discount_value' => $this->discount_value,
            'discount_type' => $this->discount_type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
