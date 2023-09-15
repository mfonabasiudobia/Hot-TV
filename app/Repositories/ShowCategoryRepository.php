<?php

namespace App\Repositories;

use App\Models\ShowCategory;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ShowCategoryRepository {


    public static function all() 
    {
        return ShowCategory::all();
    }

    public static function getShowCategoryById(int $id) : ShowCategory 
    {
            return ShowCategory::findOrFail($id);
    }

    public static function createShowCategory(array $data) : ShowCategory
    {
        return ShowCategory::create($data);
    }

    public static function updateShowCategory(array $data, int $id) : bool
    {
         return ShowCategory::find($id)->update($data);
    }

    public static function delete(int $id) : bool {
        return ShowCategory::find($id)->delete();
    }



}
