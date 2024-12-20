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
        $radius = Setting::where('key', 'ride-search-radius')->first()->value ?? 10;

        return User::where('online_status', true)
            ->whereHas('roles', function ($query) {
                $query->where('slug', RoleEnum::DRIVER->value);
            })
            ->get();
    }

    public static function getNextAvailableDriver($ride)
    {
        $radius = Setting::where('key', 'ride-search-radius')->first()->value ?? 10;

        return User::where('online_status', true)
                ->whereDoesntHave('ride_responses', function ($query) use ($ride) {
                    $query->where('ride_id', $ride->id);
                })
                ->whereHas('roles', function ($query) {
                    $query->where('slug', RoleEnum::DRIVER->value);
                })
                ->select('*')
                ->selectRaw(
                    "(3956 * acos(cos(radians(?))
                    * cos(radians(latitude))
                    * cos(radians(longitude) - radians(?))
                    + sin(radians(?))
                    * sin(radians(latitude)))) AS distance",
                    [$ride->customer_latitude, $ride->customer_longitude, $ride->customer_latitude]
                )
                ->having("distance", "<", $radius)
                ->orderBy('distance')
                ->first();
    }
}
