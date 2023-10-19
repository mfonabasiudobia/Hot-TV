<?php

namespace App\Repositories;

use App\Models\Podcast;
// use App\Models\PodcastView;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PodcastRepository {

    public static function all($sort, $s= null) 
    {
        return Podcast::query()
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
        });

        
    }

    public static function getPodcastById(int $id) : Podcast 
    {
            return Podcast::findOrFail($id);
    }

    public static function getPodcastBySlug($slug) : Podcast
    {
        return Podcast::where('slug', $slug)->firstOrFail();
    }

    public static function createPodcast(array $data) : Podcast
    {
        $podcast = Podcast::create($data);

        return $podcast;
    }

    public static function updatePodcast(array $data, int $id) : Podcast
    {
         $podcast = Podcast::find($id);
         
         $podcast->update($data);

         return $podcast;
    }

    public static function delete(int $id) : bool {
        return Podcast::find($id)->delete();
    }

    public static function getMostViewedPodcasts(){
          return Podcast::withCount('views')->orderByDesc('views_count')->get();
    }


}
