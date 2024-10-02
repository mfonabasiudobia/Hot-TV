<?php

namespace App\Jobs;

use App\Models\Video;
use Carbon\Carbon;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class ConvertVideoForDownloadingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $video;

    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    public function handle(): void
    {
        $lowBitrateFormat = (new X264)->setKiloBitrate(500);

        FFMpeg::fromDisk($this->video->disk)
            ->open($this->video->path)
            ->addFilter(function($filters) {
                $filters->resize(new Dimension(960, 540));
            })
            ->export()
            ->toDisk('public')
            ->inFormat($lowBitrateFormat)
            ->save('videos/' .$this->video->id . '.mp4');
        \Log::info('video converted into mp4 successfully');
        $this->video->update([
            'converted_for_downloading_at' => Carbon::now()
        ]);
    }
}
