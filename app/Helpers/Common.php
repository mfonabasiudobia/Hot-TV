<?php 

use App\Models\Setting;

function gs(){
    return (object) Setting::all()->pluck("value","key")->toArray();
}

//Active Currency
function ac(){
    return "$";
}

function user(){
    return auth()->user();
}
