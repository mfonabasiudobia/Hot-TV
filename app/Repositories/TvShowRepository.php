<?php

namespace App\Repositories;

use App\Models\TvShow;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class TvShowRepository {

    public static function all() 
    {
        return TvShow::all();
    }

    public static function getTvShowById(int $id) : TvShow 
    {
            return TvShow::findOrFail($id);
    }

    public static function createTvShow(array $data, array $categories) : TvShow
    {
        $tvShow = TvShow::create($data);

        $tvShow->categories()->attach($categories);

        return $tvShow;
    }

    public static function updateTvShow(array $data, $categories, int $id) : TvShow
    {
         $tvShow = TvShow::find($id);
         
         $tvShow->update($data);

         $tvShow->categories()->sync($categories);

         return $tvShow;
    }

    public static function delete(int $id) : bool {
        return TvShow::find($id)->delete();
    }



}
