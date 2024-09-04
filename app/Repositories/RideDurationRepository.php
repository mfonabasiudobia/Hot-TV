<?php

namespace App\Repositories;

use App\Models\RideDuration;
use App\Models\ShowCategory;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class RideDurationRepository {


    public static function all()
    {
        return RideDuration::all();
    }

    public static function getDurationById(int $id) : RideDuration
    {
            return RideDuration::findOrFail($id);
    }

    public static function createDuration(array $data) : RideDuration
    {
        return RideDuration::create($data);
    }

    public static function updateDuration(array $data, int $id) : bool
    {
         return RideDuration::find($id)->update($data);
    }

    public static function delete(int $id) : bool {
        return RideDuration::find($id)->delete();
    }



}
