<?php 

use Gloudemans\Shoppingcart\Facades\Cart;

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

function file_path($file = null){
    return asset('storage') . '/' . $file;
}

function get_seconds_in_time_array(){
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

function sanitize_seo_description($value){
    return str()->limit(htmlspecialchars_decode(strip_tags($value)), 100);
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