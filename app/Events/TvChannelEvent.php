<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use App\Repositories\StreamRepository;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon; 
use App\Models\Stream;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class TvChannelEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $timeArray, $infoArray;

    private $src, $title, $description, $secondsPassed;

    public function __construct()
    {
        // $records = Stream::whereDate('schedule_date', now())->get();   

        // // Initialize an array to store the formatted data
        // $this->timeArray = [];
        // $this->infoArray = [];

        // // Iterate through the data and format it as required
        // foreach ($records as $item){

        //     $this->timeArray[] = [
        //         'start' => convert_time_to_streaming_time($item->start_time),
        //         'end' => convert_time_to_streaming_time($item->end_time)
        //     ];

        //     $this->infoArray[] = [
        //         'title' => $item->title,
        //         'description' => $item->description,
        //         'start_time' => $item->start_time,
        //         'src' => file_path($item->recorded_video)
        //     ];
        // }

        // $now = Carbon::now();
        // $currentHour = $now->hour;
        // $currentMinute = $now->minute / 60;

        // // Calculate the current time in hours with fractions of an hour
        // $currentTime = $currentHour + $currentMinute;

        // foreach ($this->timeArray as $i => $schedule) {
        //     $start = $schedule["start"];
        //     $end = $schedule["end"];

        //     if ($currentTime >= $start && $currentTime < $end) {

        //           // Define your start time
        //         $startTime = Carbon::createFromTimeString($this->infoArray[$i]["start_time"]);

        //         // Get the current time
        //         $currentTime = Carbon::now();

        //         // Calculate the difference in seconds
        //         $secondsPassed = $currentTime->diffInSeconds($startTime);

        //         $this->src = $this->infoArray[$i]["src"];
        //         $this->title = $this->infoArray[$i]["title"];
        //         $this->description = $this->infoArray[$i]["description"];
        //         $this->secondsPassed = $secondsPassed;
        //         break;
        //     }
        // }

        $result = StreamRepository::getCurrentStreamingInformation();

        $this->src = $result['src'] ?? null;
        $this->title = $result['title'] ?? null;
        $this->description = $result['description'] ?? null;
        $this->secondsPassed = $result['seconds_passed'] ?? null;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('tv-channel');
    }

     public function broadcastAs(){
        return "tv-channel";
    }

    public function broadcastWith(){
       

        return [
            'title' => $this->title,
            'description' => $this->description,
            'src' => $this->src,
            'start_time' => $this->secondsPassed - 60 //continue from seconds back
        ];
    }


}
