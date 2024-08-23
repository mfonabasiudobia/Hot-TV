<?php

namespace App\Http\Livewire\TvShows;

use App\Http\Livewire\BaseComponent;
use App\Repositories\TvShowRepository;
use App\Repositories\EpisodeRepository;
use App\Repositories\CastRepository;
use App\Models\TvShowView;
use App\Models\Watchlist;

class Show extends BaseComponent
{

    public $tvShow, $seasons = [], $season_number = 1, $episodes = [];

    public $selectedEpisode, $casts = [];

    public function mount($slug){

        $this->fill([
            'tvShow' => TvShowRepository::getTvShowBySlug($slug)
        ]);

        if(request()->has(['season', 'episode'])){
            $this->fill([
                'selectedEpisode' => EpisodeRepository::getEpisodeBySlug(request('episode'), $this->tvShow->id),
                'season_number' => request('season')
            ]);
        }

        $this->fill([
            'seasons' => TvShowRepository::getTvShowSeasons($this->tvShow->id),
            'episodes' => EpisodeRepository::getEpisodesBySeason($this->tvShow->id, $this->season_number),
            'casts' => CastRepository::getCastsByShow($this->tvShow->id)
        ]);

//        $data = [
//            'user_id' => auth()->id(),
//            'tv_show_id' => $this->tvShow->id,
//            'episode_id' => $this->selectedEpisode->id ?? NULL,
//            'ip_address' => request()->ip()
//        ];


        if($this->selectedEpisode) {

            $tvShowViews = TvShowView::where('user_id',  auth()->id())
                ->where('ip_address',  request()->ip())
                ->where('tv_show_id', $this->tvShow->id)
                ->first();

            if(!$tvShowViews) {
                TvShowView::create([
                    'user_id' => auth()->id(),
                    'ip_address' => request()->ip(),
                    'tv_show_id' => $this->tvShow->id,
                    'episode_id' => $this->selectedEpisode->id,
                ]);
            } else {
                dd('if not episode');
                if($tvShowViews->episode_id == null) {

                    $tvShowViews->episode_id = $this->selectedEpisode->id;
                    $tvShowViews->save();
                } else {
                    TvShowView::create([
                        'user_id' => auth()->id(),
                        'ip_address' => request()->ip(),
                        'tv_show_id' => $this->tvShow->id,
                        'episode_id' => $this->selectedEpisode->id,
                    ]);
                }


            }

        } else {
            TvShowView::updateOrCreate([
                'user_id' => auth()->id(),
                'ip_address' => request()->ip(),
                'tv_show_id' => $this->tvShow->id,
            ], [
                'user_id' => auth()->id(),
                'ip_address' => request()->ip(),
                'tv_show_id' => $this->tvShow->id,
            ]);
        }

    }

    public function updatedSeasonNumber($value){
        $this->episodes = EpisodeRepository::getEpisodesBySeason($this->tvShow->id, $this->season_number);
    }

    public function selectEpisode($episodeId){
        $this->selectedEpisode = EpisodeRepository::getEpisodeById($episodeId);

        $this->dispatchBrowserEvent("change-episode", [
            'video_url' => file_path($this->selectedEpisode->recorded_video),
            'episode' => $this->selectedEpisode->slug,
            'season' => $this->selectedEpisode->season_number
        ]);
    }

    public function saveToWatchlist($tvShowId){
        try {

            $watchlist =  $this->tvShow->watchlists()->where('user_id', auth()->id())->first();

            if(!$watchlist){
                $watchlist = new Watchlist(['user_id' => auth()->id()]);

                $this->tvShow->watchlists()->save($watchlist);

                return toast()->success('Added To My List')->push();
            }

            $watchlist->delete();

            toast()->success('Removed From My List')->push();
        } catch (\Throwable $e) {
            toast()->danger($e->getMessage())->push();
        }
    }

    public function render()
    {
        return view('livewire.tv-shows.show')->layout('layouts.app', [
            'seo_title' => $this->tvShow->title,
            'seo_description' => sanitize_seo_description($this->tvShow->description)
        ]);
    }
}
