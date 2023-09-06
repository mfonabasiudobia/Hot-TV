<?php

namespace App\Http\Livewire\Admin\Video;

use App\Http\Livewire\BaseComponent;
use App\Repositories\StreamRepository;

class Edit extends BaseComponent
{

     public $title, $description, $start_time, $end_time, $schedule_date, $recorded_video, $stream, $thumbnail;

     public $recorded_video_path, $thumbnail_path;

     public $timeRangedAlreadyScheduled = [];

     public $stream_type = 'uploaded_video';

     public function mount($id){
        $this->stream = StreamRepository::getStreamById($id);

        $this->fill([
            'title' => $this->stream->title,
            'description' => $this->stream->description,
            'start_time' => $this->stream->start_time,
            'end_time' => $this->stream->end_time,
            'stream_type' => $this->stream->stream_type,
            'schedule_date' => $this->stream->schedule_date,
            'recorded_video_path' => $this->stream->recorded_video,
            'thumbnail_path' => $this->stream->thumbnail
        ]);

     }

     public function updatedScheduleDate($value){
        $this->timeRangedAlreadyScheduled = StreamRepository::getTimeRangeAlreadyScheduled($value);
        $this->dispatchBrowserEvent("update-time-range", ['time_range' => $this->timeRangedAlreadyScheduled ]);
     }

     public function submit(){

        $this->validate([
            'title' => 'required|string',
            'description' => 'required|max:1500',
            'schedule_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'thumbnail' => 'nullable|image',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'recorded_video' => 'nullable|file|mimetypes:video/*|max:204800',
            'stream_type' => 'required|in:uploaded_video,podcast,pedicab_stream'
        ],[
            'schedule_date.*' => 'Invalid Date Selected',
            'start_time.*' => 'Invalid Start Time Selected',
            'end_time.required' => 'Invalid End Time Selected'
        ]);

        try {

            $acceptedTimeRange = StreamRepository::acceptedTimeRange($this->start_time, $this->end_time);

            throw_unless($acceptedTimeRange, "Streaming time must be within 5 minutes, 10, 20, 30 and 120 minutes");

            $data = [
                'title' => $this->title,
                'description' => $this->description,
                'schedule_date' => $this->schedule_date,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'recorded_video' => $this->recorded_video,
                'thumbnail' => $this->thumbnail,
                'stream_type' => $this->stream_type
            ];

            throw_unless(StreamRepository::update($this->stream->id, $data), "Please try again");

            toast()->success('Cheer! Stream has been updated!')->pushOnNextPage();

            return redirect()->route('admin.dashboard');

        } catch (\Throwable $e) {
            toast()->danger($e->getMessage())->push();
        }
     }



    public function render()
    {
        return view('livewire.admin.video.edit')->layout('layouts.admin-base');
    }
}
