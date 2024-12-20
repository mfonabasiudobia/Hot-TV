<?php

namespace App\Repositories;

use App\Enums\User\RoleEnum;
use Botble\ACL\Models\User;
use App\Models\RideDuration;
use Botble\Setting\Models\Setting;
use App\Models\ShowCategory;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class DriverRepository
{

    public static function onlineRiders($ride)
    {
        return DB::table('users')
            ->select('id', 'latitude', 'longitude')
            ->where('online_status', true)
            // ->whereRaw("
            //     ST_Distance_Sphere(
            //         point(longitude, latitude),
            //         point(?, ?)
            //     ) <= ?
            // ", [$ride['cusomter_latitude'], $ride['customer_longitude'], $radius * 1000])
            ->get();
    }

    public static function getNextAvailableDriver($ride)
    {
        // TODO:
        $radius = Setting::where('key', 'ride-search-radius')->first()->value ?? 10;
        return User::where('online_status', true)
            ->whereHas('roles', function ($query) {
                $query->where('slug', RoleEnum::DRIVER->value);
            })
            ->whereRaw("
                ST_Distance_Sphere(
                    point(longitude, latitude),
                    point(?, ?)
                ) <= ?
            ", [$ride['cusomter_latitude'], $ride['customer_longitude'], $radius * 1000])
            ->whereDoesntHave('ride_responses', function ($query) use ($ride) {
                $query->where('ride_id', $ride->id);
            })
            ->orderByRaw("
                ST_Distance_Sphere(
                    point(longitude, latitude),
                    point(?, ?)
                )
            ", [$ride->customer_latitude, $ride->customer_longitude])
            ->first();
    }
}
