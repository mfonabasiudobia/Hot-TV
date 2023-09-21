<?php

namespace App\Repositories;

use App\Models\Cast;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CastRepository {

    public static function all() 
    {
        return Cast::all();
    }

    public static function getCastById(int $id) : Cast 
    {
            return Cast::findOrFail($id);
    }

    public static function getCastsByShow($tvShowId) : Collection
    {
        return Cast::whereHas('tvshows', function($q) use($tvShowId) {
            $q->where('tv_shows.id', $tvShowId);
        })->get();
    }

    public static function createCast(array $data) : Cast
    {
        $cast = Cast::create($data);

        return $cast;
    }

    public static function updateCast(array $data, int $id) : Cast
    {
         $cast = Cast::find($id);
         
         $cast->update($data);

         return $cast;
    }

    public static function delete(int $id) : bool {
        return Cast::find($id)->delete();
    }



}
