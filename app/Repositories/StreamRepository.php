<?php

namespace App\Repositories;

use App\Models\Stream;
use Carbon\Carbon;
use AppHelper;

class StreamRepository
{

    public static function getStreamById(int $id){
        return Stream::findOrFail($id);
    }

    public static function create(array $data){
        $stream = Stream::create(array_merge($data, [
            'recorded_video' => AppHelper::uploadFile($data['recorded_video'], 'streams'),
            'thumbnail' => AppHelper::uploadFile($data['thumbnail'], 'thumbnail')
        ]));

        return $stream;
    }

    public static function update(int $id, array $data){

        $stream = Stream::findOrFail($id);
        
        $stream->update(array_merge($data, [
            'recorded_video' => $data['recorded_video'] ?  AppHelper::uploadFile($data['recorded_video'], 'streams') : $stream->recorded_video,
            'thumbnail' => $data['thumbnail'] ? AppHelper::uploadFile($data['thumbnail'], 'streams') : $stream->thumbnail
        ]));

        return $stream;
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
