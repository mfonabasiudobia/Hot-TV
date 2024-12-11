<?php

namespace App\Repositories;

use App\Models\Shoutout;

class ShoutoutRepository
{
    public static function all($sort, $s= null)
    {
        return Shoutout::query()
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

    public static function getById(int $id) : Shoutout
    {
        return Shoutout::findOrFail($id);
    }

    public static function getBySlug($slug) : Shoutout
    {
        return Shoutout::where('slug', $slug)->firstOrFail();
    }

    public static function create(array $data) : Shoutout
    {
        $shoutout = Shoutout::create($data);

        return $shoutout;
    }

    public static function update(array $data, int $id) : Shoutout
    {
        $shoutout = Shoutout::find($id);

        $shoutout->update($data);

        return $shoutout;
    }

    public static function delete(int $id) : bool {
        return Shoutout::find($id)->delete();
    }

    public static function getMostViewedPodcasts(){
        return Shoutout::withCount('views')->orderByDesc('views_count')->get();
    }
}
