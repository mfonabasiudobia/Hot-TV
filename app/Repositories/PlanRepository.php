<?php

namespace App\Repositories;

use App\Models\Plan;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PlanRepository {


    public static function all() : Collection
    {
        return Plan::all();
    }



}
