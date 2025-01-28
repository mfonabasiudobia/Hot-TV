<?php

namespace App\Jobs;

use App\Models\Video;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class UploadVideoToStorage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $video;
    public $model;

     public function __construct(Video $video, $model)
     {
         $this->video = $video;
         $this->model = $model;
     }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $ffmpegVideo = FFMpeg::fromDisk($this->video->disk)->open($this->video->path);
            $durationInSeconds = $ffmpegVideo->getFormat()->get('duration');
            $this->model->duration = gmdate('H:i:s', $durationInSeconds);
            $this->model->save();
        } catch (\Exception $th) {
            \Log::error('Exception occurred: ' . $th->getMessage(), ['exception' => $th]);
        }
    }
}
