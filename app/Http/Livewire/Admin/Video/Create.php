<?php

namespace App\Http\Livewire\Admin\Video;

use App\Http\Livewire\BaseComponent;
use App\Repositories\StreamRepository;
use App\Repositories\TvShowRepository;
use App\Repositories\EpisodeRepository;
use App\Repositories\PodcastRepository;

class Create extends BaseComponent
{

    public $title, $description, $start_time, $end_time, $schedule_date, $recorded_video, $thumbnail, $disk = 'local';

    public $timeRangedAlreadyScheduled = [];

    public $stream_type = 'uploaded_video', $uploaded_video_type;

    public $show_category_id, $tv_shows = [], $tv_show_id, $tv_show_seasons = [], $season_number;

    public $tv_show_episodes = [], $episode_id, $podcasts = [], $podcast_id;

    public function updatedScheduleDate($value){
        $this->timeRangedAlreadyScheduled = StreamRepository::getTimeRangeAlreadyScheduled($value);

        $this->dispatchBrowserEvent("update-time-range", ['time_range' => $this->timeRangedAlreadyScheduled ]);
    }

    public function updatedShowCategoryId($value){
        $this->tv_shows = TvShowRepository::getTvShowsByCategory($value);
    }

    public function updatedTvShowId($value){
        $this->tv_show_seasons = TvShowRepository::getTvShowSeasons($value);
    }

    public function updatedSeasonNumber($value){
        $this->tv_show_episodes = EpisodeRepository::getEpisodesBySeason($this->tv_show_id, $value);
    }

    public function updatedEpisodeId($value){
        $episode = EpisodeRepository::getEpisodeById($value);
        $this->description = $episode->description;
        $this->title = $episode->title;
        $this->recorded_video = $episode->video->path;
        $this->disk = $episode->video->disk;
        $this->dispatchBrowserEvent('added-tv-episode', $this->description);
    }

    public function updatedPodcastId($value){
        $podcast = PodcastRepository::getPodcastById($value);
        $this->description = $podcast->description;
        $this->title = $podcast->title;
        $this->recorded_video = $podcast->video->path;
        $this->disk = $podcast->video->disk;

        $this->dispatchBrowserEvent('added-tv-episode', $this->description);
    }



    public function submit(){

        $this->validate([
            'title' => 'required|string',
            'description' => 'required',
            'schedule_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i:s',
            'thumbnail' => 'required',
            'end_time' => 'required|date_format:H:i:s|after:start_time',
            'recorded_video' => 'required',
            'stream_type' => 'required|in:uploaded_video,podcast,pedicab_stream',
            'uploaded_video_type' => 'nullable',
            'show_category_id' => 'nullable'
        ],[
            'schedule_date.*' => 'Invalid Date Selected',
            'start_time.*' => 'Invalid Start Time Selected',
            'end_time.required' => 'Invalid End Time Selected'
        ]);

        try {

            $acceptedTimeRange = StreamRepository::acceptedTimeRange($this->start_time, $this->end_time);

            // throw_unless($acceptedTimeRange, "Streaming time must be within 5 minutes, 10, 20, 30 and 120 minutes");

            // $videoLength = StreamRepository::getVideoLengthInSeconds('storage/' . $this->recorded_video);
            // $scheduledLength = StreamRepository::getScheduledTimeInSeconds($this->start_time, $this->end_time);

            // $diff = $scheduledLength - $videoLength;

            // throw_if($diff < -120 || $diff > 120, "The time scheduled for the video must match with the video length");

            $data = [
                'title' => $this->title,
                'slug' => str()->slug($this->title),
                'description' => $this->description,
                'schedule_date' => $this->schedule_date,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'recorded_video' => $this->recorded_video,
                'disk'  => $this->disk,
                'thumbnail' => $this->thumbnail,
                'stream_type' => $this->stream_type,
                'uploaded_video_type' => $this->uploaded_video_type,
                'show_category_id' => $this->show_category_id
            ];

            throw_unless(StreamRepository::create($data), "Please try again");

            toast()->success('Cheer! Video has been added to stream pool!')->pushOnNextPage();

            return redirect()->route('admin.dashboard');

        } catch (\Throwable $e) {
            toast()->danger($e->getMessage())->push();
        }
    }

    public function render()
    {
        return view('livewire.admin.video.create')->layout('layouts.admin-base');
    }
}
