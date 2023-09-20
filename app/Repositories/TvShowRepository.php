<?php

namespace App\Repositories;

use App\Models\TvShow;
use App\Models\Episode;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class TvShowRepository {

    public static function all($sort, $s= null) 
    {
        return TvShow::query()
        ->when($sort['sortByTitle'], function($q) use($sort) {
            $q->orderBy('title', $sort['sortByTitle']);
        })
        ->when($sort['sortByDate'], function($q) use($sort) {
            $q->orderBy('created_at', $sort['sortByDate']);
        })
        ->when($sort['sortByTime'] === "month", function($q) use($sort) {
            $q->whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month);
        })
        ->when($sort['sortByTime'] === "today", function($q) use($sort) {
            $q->whereDate('created_at', now()->toDateString());
        })
        ->when($sort['sortByTime'] === "week", function($q) use($sort) {
            $q->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        })
        ->when($s, function($q) use($s) {
            $q->where('title', 'like', '%' . $s . '%')
            ->orWhereHas('categories', function ($q) use ($s) {
                $q->where('name', 'like', '%' . $s . '%');
            });
        });

        
    }

    public static function getTvShowById(int $id) : TvShow 
    {
            return TvShow::findOrFail($id);
    }

    public static function getTvShowBySlug($slug) : TvShow
    {
        return TvShow::where('slug', $slug)->firstOrFail();
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

    public static function getTvShowSeasons($tvshowId) : array{
        return Episode::groupBy('tv_show_id', 'season_number')->distinct()->where('tv_show_id',
        $tvshowId)->select("episodes.season_number")->pluck('season_number')->toArray();
    }

    public static function delete(int $id) : bool {
        return TvShow::find($id)->delete();
    }



}
