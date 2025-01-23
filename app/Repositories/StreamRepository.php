<?php

namespace App\Repositories;

use App\Models\Stream;
use Carbon\Carbon;
use AppHelper;
use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;
use Illuminate\Support\Facades\Storage;

class StreamRepository
{

    public static function getStreamById(int $id){
        return Stream::findOrFail($id);
    }

    public static function create(array $data){
        $stream = Stream::create(array_merge($data, []));

        return $stream;
    }

    public static function update(int $id, array $data){

        $stream = Stream::findOrFail($id);

        $stream->update(array_merge($data, []));

        return $stream;
    }

    public static function getVideoLengthInSeconds($videoPath){
        // Initialize FFProbe
        $ffprobe = FFProbe::create();

        // Get the duration of the video
        $duration = $ffprobe->format($videoPath)->get('duration');

        return $duration;


            // Convert duration to a human-readable format (e.g., HH:MM:SS)
            // $formattedDuration = gmdate('H:i:s', (int)$duration);

                //  dd($formattedDuration);
    }

    public static function getScheduledTimeInSeconds($startTime, $endTime){
        // Split the start time and end time into hours and minutes
        list($startHour, $startMinute) = explode(":", $startTime);
        list($endHour, $endMinute) = explode(":", $endTime);

        // Calculate the total seconds for each time
        $startSeconds = ($startHour * 3600) + ($startMinute * 60);
        $endSeconds = ($endHour * 3600) + ($endMinute * 60);

        // Calculate the time difference in seconds
        $timeDifferenceInSeconds = $endSeconds - $startSeconds;

        return $timeDifferenceInSeconds;
    }

    public static function getTimeRangeAlreadyScheduled($selectedDate){
        return Stream::whereDate('schedule_date', $selectedDate)->pluck('start_time', 'end_time')
         ->map(function($startTime, $endTime) {
            return ['from' => $startTime, 'to' => $endTime];
         })
         ->values()
         ->toArray();
    }

    public static function diffBetweenTimeInHours($startTime, $endTime){
          $startTime = Carbon::parse($startTime);
          $endTime = Carbon::parse($endTime);

          return $endTime->diffInHours($startTime);
    }

    public static function acceptedTimeRange($startTime, $endTime){
        $startTime = Carbon::parse($startTime);
        $endTime = Carbon::parse($endTime);

        $timeDifference = $endTime->diffInMinutes($startTime);

        return in_array($timeDifference, [5, 10, 20, 30, 60, 120]);
    }

    public static function getAllStreams(){
         return Stream::query()
            ->select('id', 'title', 'description', 'schedule_date', 'start_time', 'end_time')
            ->get()
            ->map(function($stream) {
                return [
                    'title' => $stream->title,
                    'id' => $stream->id,
                    'description' => $stream->description,
                    'start' => $stream->schedule_date . ' ' . $stream->start_time,
                    'end' => $stream->schedule_date . ' ' . $stream->end_time,
                ];
         })
         ->values()
         ->toArray();
    }

    public static function getCurrentStreamingInformation(){

        $records = Stream::whereDate('schedule_date', now())->get();
        // $records = Stream::orderBy('id', 'desc')->limit(1)->get();
        $result = [];
        // Initialize an array to store the formatted data
        $timeArray = [];
        $infoArray = [];

        // Iterate through the data and format it as required
        foreach ($records as $item){
            // \Log::info('url', [Storage::disk($item->disk)->url($item->recorded_video)]);
            // \Log::info('file', [asset('storage/'. $item->recorded_video)]);

            $timeArray[] = [
                'start' => convert_time_to_streaming_time($item->start_time),
                'end' => convert_time_to_streaming_time($item->end_time)
            ];

            $infoArray[] = [
                'title' => $item->title,
                'description' => $item->description,
                'start_time' => $item->start_time,
                'id' => $item->id,
                'src' => Storage::disk($item->disk)->url($item->recorded_video)
            ];
        }
        \Log::info('time array' . json_encode($timeArray));
        $now = Carbon::now();
        $currentHour = $now->hour;
        $currentMinute = $now->minute / 60;

        // Calculate the current time in hours with fractions of an hour
        $currentTime = $currentHour + $currentMinute;

        foreach ($timeArray as $i => $schedule) {
            $start = $schedule["start"];
            $end = $schedule["end"];

            if ($currentTime >= $start && $currentTime < $end) {
                \Log::info('time matched........');
                  // Define your start time
                $startTime = Carbon::createFromTimeString($infoArray[$i]["start_time"]);

                // Get the current time
                $currentTime = Carbon::now();

                // Calculate the difference in seconds
                $secondsPassed = $currentTime->diffInSeconds($startTime);

                $result['src'] = $infoArray[$i]["src"];
                $result['title'] = $infoArray[$i]["title"];
                $result['description'] = $infoArray[$i]["description"];
                $result['id'] = $infoArray[$i]["id"];
                $result['seconds_passed'] = $secondsPassed;
                break;
            }
        }


        return $result;

    }

    public static function getMostStreamedVideos(){
          return Stream::withCount('views')->orderByDesc('views_count')->get();
    }

    public static function getTvChannelBySlug($slug) : Stream {
        return Stream::where('slug',$slug)->firstOrFail();
    }


}
