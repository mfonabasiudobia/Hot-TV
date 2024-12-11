<?php

namespace App\Http\Resources\Api\V1\Customer\Ecommerce;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        $now = \Carbon\Carbon::now();
        $price = $this->price;
        $oldPrice = null;

        if($this->start_date != null && $this->end_date == null) {

            if($now->gt(\Carbon\Carbon::parse($this->start_date))) {
                $price = $this->sale_price;
                //$oldPrice = $this->price;
            } else {
                $price = $this->price;
                $oldPrice = null;
            }
        } elseif($this->start_date && $this->end_date) {

            if($now->gt(\Carbon\Carbon::parse($this->start_date)) && $now->lt(\Carbon\Carbon::parse($this->end_date))) {

                $price = $this->sale_price;
                $oldPrice = $this->price;
            } else {
                $price = $this->price;
                $oldPrice = null;
            }
        } else {
            $price = $this->price;
            $oldPrice = null;
        }


        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'content' => $this->content,
            'status' => $this->status,
            'images' => $this->images,
            'sku' => $this->sku,
            'quantity' => $this->quantity,
            'brand' => new BrandResource($this->brand),
            'price' =>  $oldPrice ? ac(). number_format($oldPrice, 2) : null,
            'sale_price' => ac(). number_format($price, 2),
            'length' => $this->length,
            'wide' => $this->wide,
            'height' => $this->height,
            'weight' => $this->weight,
            'tax_id' => $this->tax_id,
            'views' => $this->views,
            'stock_status' => $this->stock_status,
            'barcode' => $this->barcode,
            'cost_per_item' => $this->cost_per_item,
            'generate_license_code' => $this->generate_license_code,
            'variations' => ProductVariationResource::collection($this->variations),
        ];
    }
}
