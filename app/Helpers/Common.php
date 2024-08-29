<?php

use Botble\Ecommerce\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Pagination\LengthAwarePaginator;

function gs(){
    return (object) \DB::table('settings')->pluck("value","key")->toArray();
}

//Active Currency
function ac(){
    return "$";
}

function user(){
    return auth()->user();
}

function upload_file($file, $filePath, $previousPath = null, $isupdating = false) {
    if(!$file && $isupdating) return $previousPath;// return previous path if we updating file and file upload exists

    if (file_exists($previousPath)) unlink($previousPath);

    if(!$file) return null;

    return 'storage/' . $file->storeAs($filePath, Str::uuid() . '.' .$file->extension());
}

function upload_gallery_file($file, $filePath, $previousPath = null, $isUpdating = false) {
    if(!$file && $isUpdating) return $previousPath;// return previous path if we updating file and file upload exists

    if (file_exists($previousPath)) unlink($previousPath);
    $uuid = Str::uuid();
    if(!$file) return null;
    $extension = $file->extension();
    $fileName = $uuid . '.' .$extension;
    $fileNameThumbnail = $uuid . '-150x150.' .$extension;
    $fileSaveAs = $file->storeAs($filePath, $fileName);
    $fileSaveAsThumbnail = $file->storeAs($filePath, $fileNameThumbnail);
    $path = 'storage/' . $fileSaveAs;
    $size = filesize($path);

    $thumb_img = Image::make('storage/' . $fileSaveAsThumbnail)->resize(150, 150, function ($constraint) {
        $constraint->aspectRatio();
    });

    return [
        'file_path' => $fileSaveAs,
        'name' => $fileName,
        'mime_type' => "mime/$extension",
        'size' => $size

    ];
}

function upload_avatar($file, $filePath, $previousPath = null, $isupdating = false) {
    if(!$file && $isupdating) return $previousPath;// return previous path if we updating file and file upload exists

    if (file_exists($previousPath)) unlink($previousPath);

    if(!$file) return null;

    return $file->storeAs($filePath, Str::uuid() . '.' .$file->extension());
}

function file_path($file = null){
    return asset('storage') . '/' . $file;
}

function get_seconds_in_time_array() {
     $intervals = [];

     for ($i = 1; $i <= 180; $i++) {
        // 180 minutes=3 hours
        $seconds=$i * 60; // Convert minutes to seconds

        $hours = floor($i / 60);
        $minutes = $i % 60;

        $title = '';

        if ($hours > 0) {
            $title .= $hours === 1 ? '1 hr' : $hours . ' hrs';
        }

        if ($minutes > 0) {
            if (!empty($title)) {
                $title .= ' ';
            }
            $title .= $minutes === 1 ? '1 minute' : $minutes . ' minutes';
        }

        $intervals[]=[
            'seconds'=> $seconds,
            'title' => $title,
         ];
    }

    return $intervals;
}

function convert_seconds_to_time($seconds){
    // Calculate hours and minutes
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds % 3600) / 60);

    return "{$hours}hr {$minutes}min";
}

function view_count($number) {
    if ($number >= 1000) {
        $formattedNumber = number_format($number / 1000, 1) . 'k';
    } else {
        $formattedNumber = $number;
    }
    return $formattedNumber;
}

function sub_total(){
    $total = 0;

    foreach (Cart::instance('product')->content() as $cart) {
        $total += $cart->model->price*$cart->qty;
    }

    return $total;
}

function discount_amount(){
    $total = 0;

    foreach (Cart::instance('product')->content() as $cart) {
        if($cart->model->sale_price > 0){
            $total += ($cart->model->price-$cart->model->sale_price)*$cart->qty;
        }
    }

    return $total;
}

function tax_amount(){
    return 0;
}

function total_amount(){
    return sub_total() - discount_amount() + tax_amount();
}

function sanitize_seo_description($value, $limit = 100){
    return str()->limit(htmlspecialchars_decode(strip_tags($value)), $limit);
}

function admin_id_array(){

    return [1, 3];
}

function is_user_logged_in(){

    if(auth()->check()){
        if(!in_array(auth()->id(), admin_id_array())) return true;
    }

    return false;
}

function convert_time_to_streaming_time($time){
    list($hour, $minute) = explode(":", $time);
    $decimalTime = (int)$hour + ((int)$minute / 60);

    return $decimalTime;
}

function diff_start_end_time_seconds($startTime, $endTime){
        // Split the start time and end time into hours and minutes
        list($startHour, $startMinute) = explode(":", $startTime);
        list($endHour, $endMinute) = explode(":", $endTime);

        // Calculate the total seconds for each time
        $startSeconds = ($startHour * 3600) + ($startMinute * 60);
        $endSeconds = ($endHour * 3600) + ($endMinute * 60);

        // Calculate the time difference in seconds
        $timeDifferenceInSeconds = $endSeconds - $startSeconds;

        return $timeDifferenceInSeconds;
}

function customPagination(LengthAwarePaginator $lengthAwarePaginator): array
{
    return [
        'total'         => $lengthAwarePaginator->total(),
        'per_page'      => $lengthAwarePaginator->perPage(),
        'current_page'  => $lengthAwarePaginator->currentPage(),
        'last_page'     => $lengthAwarePaginator->lastPage(),
        'next_page_url' => $lengthAwarePaginator->nextPageUrl(),
        'prev_page_url' => $lengthAwarePaginator->previousPageUrl(),
        'from'          => $lengthAwarePaginator->firstItem(),
        'to'            => $lengthAwarePaginator->lastItem(),
    ];
}

function getProductSalePrice(Product $product): array
{
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
        'price' => $price,
        'old_price' => $oldPrice
    ];
}

function calculateDiscount($cart)
{
    $discount = 0;
    foreach($cart as $item) {
        if(!is_null($item->options->old_price)) {
            $discount +=  $item->options->old_price - $item->price;
        }
    }
    return number_format($discount, 2);

}

function getSubTotal($cart)
{
    $subTotal = 0;
    foreach($cart as $item) {
        if(!is_null($item->options->old_price)) {
            $subTotal +=  $item->options->old_price;
        } else {
            $subTotal +=  $item->price;
        }
    }
    return number_format($subTotal, 2);

}
