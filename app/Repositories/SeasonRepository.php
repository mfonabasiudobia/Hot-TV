<?php

namespace App\Repositories;

use App\Models\Episode;
use App\Models\Season;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class SeasonRepository {

    public static function all()
    {
        return Season::query();
    }

    public static function getSeasonById(int $id) : Season
    {
            return Season::findOrFail($id);
    }

    public static function getSeasonBySlug($slug, $tvShowId) : Season
    {
        return Season::where('slug', $slug)->where('tv_show_id', $tvShowId)->first();
    }

    public static function createSeason(array $data) : Season
    {
        $season = Season::create($data);
        return $season;
    }

    public static function updateSeason(array $data, int $id) : Season
    {
        $season = Season::find($id);
        $season->update($data);
        return $season;
    }

    public static function getSeasonsBytvShowId($tvshowId){
        return Season::where('tv_show_id', $tvshowId)->get();
    }

    public static function delete(int $id) : bool {
        return Season::find($id)->delete();
    }
}
