<?php

namespace App\Jobs;

use App\Enums\VideoDiskEnum;
use App\Models\Video;
use Carbon\Carbon;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class ConvertVideoForStreamingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $video;
    public $title;

    public function __construct(Video $video, string $title)
    {
        $this->video = $video;
        $this->title = $title;
    }

    public function handle(): void
    {
        $lowBitrateFormat = (new X264)->setKiloBitrate(500);
        $midBitrateFormat = (new X264)->setKiloBitrate(1500);
        $highBitrateFormat = (new X264)->setKiloBitrate(3000);

        FFMpeg::fromDisk($this->video->disk)
            ->open($this->video->path)
            ->exportForHLS()
            ->toDisk(VideoDiskEnum::DISK->value)
            ->addFormat($lowBitrateFormat)
            ->addFormat($midBitrateFormat)
            ->addFormat($highBitrateFormat)
            ->save(VideoDiskEnum::TV_SHOWS->value . $this->title . '/' . $this->video->uuid . '.m3u8');

        \Log::info('video converted into m3u8 successfully');
        $this->video->update([
            'converted_for_streaming_at' => Carbon::now()
        ]);
    }
}
