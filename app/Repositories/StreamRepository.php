<?php

namespace App\Repositories;

use App\Models\Stream;
use Carbon\Carbon;
use AppHelper;
use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;

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


}
