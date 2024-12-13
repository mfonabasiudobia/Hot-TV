<?php

namespace App\Repositories;

use App\Models\RideDuration;
use App\Models\ShowCategory;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class DriverRepository {

    public static function onlineRiders
    {
        return DB::table('user')
            ->select('id', 'latitude', 'longitude')
            ->where('online_status', true)
            // ->whereRaw("
            //     ST_Distance_Sphere(
            //         point(longitude, latitude),
            //         point(?, ?)
            //     ) <= ?
            // ", [$ride['pickup_lng'], $ride['pickup_lat'], $radius * 1000]) 
            ->get();
    }

}
