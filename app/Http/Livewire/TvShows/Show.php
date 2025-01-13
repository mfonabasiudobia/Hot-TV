<?php

namespace App\Http\Livewire\TvShows;

use App\Enums\VideoDiskEnum;
use App\Http\Livewire\BaseComponent;
use App\Models\Season;
use App\Repositories\TvShowRepository;
use App\Repositories\EpisodeRepository;
use App\Repositories\CastRepository;
use App\Models\TvShowView;
use App\Models\Watchlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Show extends BaseComponent
{

    public $tvShow, $seasons = [], $season_number = 1, $seasonId, $episodes = [];

    public $selectedEpisode, $casts = [];
    public $user;

    public function mount($slug){

        if(Auth::check()) {
            $this->user = Auth::user();
        }
        $this->fill([
            'tvShow' => TvShowRepository::getTvShowBySlug($slug)
        ]);


        if(request()->has(['season', 'episode'])){
            $this->fill([
                'selectedEpisode' => EpisodeRepository::getEpisodeBySlug(request('episode'), $this->tvShow->id),
                'season_number' => request('season'),
            ]);
        }

        $this->fill([
            'seasons' => TvShowRepository::getTvShowSeasons($this->tvShow->id),

            'casts' => CastRepository::getCastsByShow($this->tvShow->id)
        ]);

        if($this->tvShow->seasons()->exists()) {
            $this->episodes = EpisodeRepository::getEpisodesBySeason($this->tvShow->id, request('season') ?? $this->seasons[0]->id);
        }
        //dd(Storage::disk('video_disk')->url(Str::slug($this->tvShow->title) . '/' . $this->tvShow->video->uuid . '.mp4'));

//        $data = [
//            'user_id' => auth()->id(),
//            'tv_show_id' => $this->tvShow->id,
//            'episode_id' => $this->selectedEpisode->id ?? NULL,
//            'ip_address' => request()->ip()
//        ];


        $tvShowViews = TvShowView::where('user_id',  auth()->id())
            ->where('ip_address',  request()->ip())
            ->where('tv_show_id', $this->tvShow->id)
            ->first();

        if($this->selectedEpisode) {
            if(!$tvShowViews) {
                TvShowView::create([
                    'user_id' => auth()->id(),
                    'ip_address' => request()->ip(),
                    'tv_show_id' => $this->tvShow->id,
                    'episode_id' => $this->selectedEpisode->id,
                    'season' => $this->season_number
                ]);
            } else {
                if($tvShowViews->episode_id == null) {

                    $tvShowViews->episode_id = $this->selectedEpisode->id;
                    $tvShowViews->season = $this->season_number;
                    $tvShowViews->save();
                }
                if($tvShowViews->episode_id != $this->selectedEpisode->id) {
                    TvShowView::create([
                        'user_id' => auth()->id(),
                        'ip_address' => request()->ip(),
                        'tv_show_id' => $this->tvShow->id,
                        'episode_id' => $this->selectedEpisode->id,
                        'season' => $this->season_number,
                    ]);
                }
            }

        } else {
            if(!$tvShowViews) {
                TvShowView::create([
                    'user_id' => auth()->id(),
                    'ip_address' => request()->ip(),
                    'tv_show_id' => $this->tvShow->id,
                ]);
            }

        }
    }

    public function updatedSeasonNumber($value){
        $this->episodes = EpisodeRepository::getEpisodesBySeason($this->tvShow->id, $value);
    }

    public function selectSeason()
    {
        $season = Season::find($this->season_number);
        $episodeVideo = $season && $season->video ? $season->video->stream_path : file_path($season->recorded_video);

        $this->dispatchBrowserEvent("change-episode", [
            'not_subscribed' => !($this->user && $this->user->subscription),
            'video_url' => $episodeVideo,
            'episode' => $season->episodes[0]->slug ?? null,
            'season' => $season->id
        ]);
    }

    public function selectEpisode($episodeId){
        $this->selectedEpisode = EpisodeRepository::getEpisodeById($episodeId);
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
                'season' => $this->season_number
            ]);
        } else {

            if($tvShowViews->episode_id == null) {

                $tvShowViews->episode_id = $this->selectedEpisode->id;
                $tvShowViews->season = $this->season_number;
                $tvShowViews->save();
            }

            if($tvShowViews->episode_id != $this->selectedEpisode->id) {
                TvShowView::create([
                    'user_id' => auth()->id(),
                    'ip_address' => request()->ip(),
                    'tv_show_id' => $this->tvShow->id,
                    'episode_id' => $this->selectedEpisode->id,
                    'season' => $this->season_number,
                ]);
            }
        }

        if($this->user && $this->user->subscription) {
            $episodeVideo = $this->selectedEpisode && $this->selectedEpisode->video ? $this->selectedEpisode->video->stream_path : file_path($this->tvShow->video->recorded_video);
            $notSubscribed = false;
        } else {
            $episodeVideo = $this->selectedEpisode && $this->selectedEpisode->video ? $this->selectedEpisode->video->stream_path : file_path($this->tvShow->video->recorded_video);
            $notSubscribed = true;
        }
        // dd($episodeVideo);
        $this->dispatchBrowserEvent("change-episode", [
            'not_subscribed' => $notSubscribed,
            'video_url' => $episodeVideo,
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

    // public function setShowDuration()
    // {
    //     $duration = $this->tvShow->episodes()
    //             ->selectRaw('SEC_TO_TIME(SUM(TIME_TO_SEC(duration))) as total_duration')
    //             ->value('total_duration');
    //     $duration = preg_replace('/\..*/', '', $duration);
    //     if($duration == '') return 0;

    //     list($hours, $minutes, $seconds) = explode(':', $duration);

    //     $totalSeconds = ($hours * 3600) + ($minutes * 60) + $seconds;

    //     $this->showDuration = $totalSeconds;
    // }
}
