<?php

namespace App\Repositories;

use App\Models\Ride;
use App\Models\ShowCategory;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class RideRepository {


    public static function all()
    {
        return Ride::all();
    }

    public static function getById(int $id) : Ride
    {
            return Ride::findOrFail($id);
    }

    public static function create(array $data) : Ride
    {
        return Ride::create($data);
    }

    public static function update(array $data, int $id) : bool
    {
         return Ride::find($id)->update($data);
    }

    public static function delete(int $id) : bool {
        return Ride::find($id)->delete();
    }
}
