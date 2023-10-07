<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon; 
use App\Models\Stream;

class TvChannelEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $timeArray, $infoArray;

    private $src, $title, $description;

    public function __construct()
    {
        $records = Stream::whereDate('schedule_date', now())->get();   

        // Initialize an array to store the formatted data
        $this->timeArray = [];
        $this->infoArray = [];

        // Iterate through the data and format it as required
        foreach ($records as $item){

            $this->timeArray[] = [
                'start' => convert_time_to_streaming_time($item->start_time),
                'end' => convert_time_to_streaming_time($item->end_time)
            ];

            $this->infoArray[] = [
                'title' => $item->title,
                'description' => $item->description,
                'src' => file_path($item->recorded_video)
            ];
        }

        $now = Carbon::now();
        $currentHour = $now->hour;
        $currentMinute = $now->minute / 60;

        // Calculate the current time in hours with fractions of an hour
        $currentTime = $currentHour + $currentMinute;

        foreach ($this->timeArray as $i => $schedule) {
            $start = $schedule["start"];
            $end = $schedule["end"];

            if ($currentTime >= $start && $currentTime < $end) {
                $this->src = $this->infoArray[$i]["src"];
                $this->title = $this->infoArray[$i]["title"];
                $this->description = $this->infoArray[$i]["description"];

                break;
            }
        }

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('public.tv-channel.1');
    }

     public function broadcastAs(){
        return "tv-channel";
    }

    public function broadcastWith(){

        return [
            'title' => $this->title,
            'description' => $this->description,
            'src' => $this->src
        ];
    }


}
