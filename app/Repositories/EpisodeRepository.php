<?php

namespace App\Repositories;

use App\Models\Episode;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class EpisodeRepository {

    public static function all() 
    {
        return Episode::query();
    }

    public static function getEpisodeById(int $id) : Episode 
    {
            return Episode::findOrFail($id);
    }

    public static function getEpisodeBySlug($slug, $tvShowId) : Episode
    {
        return Episode::where('slug', $slug)->where('tv_show_id', $tvShowId)->first();
    }

    public static function createEpisode(array $data) : Episode
    {
        $episode = Episode::create($data);

        return $episode;
    }

    public static function updateEpisode(array $data, int $id) : Episode
    {
         $episode = Episode::find($id);
         
         $episode->update($data);

         return $episode;
    }

    public static function getEpisodesBySeason($tvshowId, $seasonNumber){
        return Episode::where('season_number', $seasonNumber)->where('tv_show_id', $tvshowId)->get();
    }

    public static function delete(int $id) : bool {
        return Episode::find($id)->delete();
    }



}
