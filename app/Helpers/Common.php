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