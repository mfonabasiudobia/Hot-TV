<?php

namespace App\Jobs;

use App\Enums\VideoDiskEnum;
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

    public $basePath;
    public $video;
    public $title;

    public function __construct($basePath, Video $video, $title)
    {
        $this->basePath = $basePath;
        $this->video = $video;
        $this->title = $title;
    }

    public function handle(): void
    {
        $lowBitrateFormat = (new X264)->setKiloBitrate(500);

        //$lowBitrateFormat = (new X264)->setKiloBitrate(500);
        $midBitrateFormat = (new X264)->setKiloBitrate(1500);
        $highBitrateFormat = (new X264)->setKiloBitrate(3000);

        FFMpeg::fromDisk($this->video->disk)
            ->open($this->video->path)
            ->addFilter(function($filters) {
                $filters->resize(new Dimension(960, 540));
            })
            ->export()
            ->toDisk(VideoDiskEnum::DISK->value)
            ->inFormat($lowBitrateFormat)
            ->inFormat($midBitrateFormat)
            ->inFormat($highBitrateFormat)
            ->save( $this->basePath . $this->title . '/' . $this->video->uuid . '.mp4');
        \Log::info('video converted into mp4 successfully');
        $this->video->update([
            'converted_for_downloading_at' => Carbon::now()
        ]);
    }
}
