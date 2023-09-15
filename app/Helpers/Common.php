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

function upload_file($file, $filePath, $previousPath = null, $isupdating = false) {
    if(!$file && $isupdating) return $previousPath;// return previous path if we updating file and file upload exists

    if (file_exists($previousPath)) unlink($previousPath);

    if(!$file) return null;

    return 'storage/' . $file->storeAs($filePath, Str::uuid() . '.' .$file->extension());
}

function file_path($file = null){
    return asset('storage') . '/' . $file;
}
