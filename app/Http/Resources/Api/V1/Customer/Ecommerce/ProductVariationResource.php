<?php

namespace App\Http\Resources\Api\V1\Customer\Ecommerce;

use Botble\Ecommerce\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariationResource extends JsonResource
{
    public function toArray($request)
    {

        $product = Product::where('id', $this->product_id)->first();

        $now = \Carbon\Carbon::now();
        $price = $product->price;
        $oldPrice = null;

        if($product->start_date != null && $product->end_date == null) {

            if($now->gt(\Carbon\Carbon::parse($product->start_date))) {
                $price = $product->sale_price;
                //$oldPrice = $this->price;
            } else {
                $price = $product->price;
                $oldPrice = null;
            }
        } elseif($product->start_date && $product->end_date) {

            if($now->gt(\Carbon\Carbon::parse($product->start_date)) && $now->lt(\Carbon\Carbon::parse($product->end_date))) {

                $price = $product->sale_price;
                $oldPrice = $product->price;
            } else {
                $price = $product->price;
                $oldPrice = null;
            }
        } else {
            $price = $product->price;
            $oldPrice = null;
        }


        return [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'content' => $product->content,
            'status' => $product->status,
            'images' => $product->images,
            'sku' => $product->sku,
            'quantity' => $product->quantity,
            'price' =>  $oldPrice ? ac(). number_format($oldPrice, 2) : null,
            'sale_price' => ac(). number_format($price, 2),
            'length' => $product->length,
            'wide' => $product->wide,
            'height' => $product->height,
            'weight' => $product->weight,
            'tax_id' => $product->tax_id,
            'views' => $product->views,
            'stock_status' => $product->stock_status,
            'barcode' => $product->barcode,
            'cost_per_item' => $product->cost_per_item,
            'generate_license_code' => $product->generate_license_code,
        ];
    }
}
