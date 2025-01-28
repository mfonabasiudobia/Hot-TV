<?php

namespace App\Repositories;

use App\Enums\User\StatusEnum;
use App\Enums\Ride\DriverRideStatusEnum;
use App\Enums\User\RoleEnum;
use Botble\ACL\Models\User;
use Botble\Setting\Models\Setting;

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

    public static function allOnlineDrivers()
    {
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
                // ->where('status', StatusEnum::ACTIVATED->value)
                ->whereDoesntHave('ride_responses', function ($query) use ($ride) {
                    $query->where('ride_id', $ride->id);
                })
                ->whereDoesntHave('ride_responses', function ($query) use ($ride) {
                    $query->where('ride_id', '!=', $ride->id)
                    ->where('status', DriverRideStatusEnum::PENDING->value)
                    ->where('status', DriverRideStatusEnum::ACCEPTED->value);
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
