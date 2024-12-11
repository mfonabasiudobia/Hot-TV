<?php

namespace App\Http\Resources\Api\V1\Customer\Ecommerce;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "rowId" => $this->rowId,
            "id" => $this->id,
            "name" => $this->name,
            "qty" => $this->qty,
            "price" => $this->price,
            "options" => $this->options,
            "tax" => $this->tax,
            "isSaved" => $this->isSaved,
            "subtotal" => $this->subtotal,
            "total"  => $this->total,
            'product' => new ProductResource($this->model)
        ];
    }
}
