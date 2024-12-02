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

    public $basePath;
    public $video;
    public $title;

    public function __construct($basePath, Video $video, string $title)
    {
        $this->basePath = $basePath;
        $this->video = $video;
        $this->title = $title;
    }

    public function handle(): void
    {
        try {
            $lowBitrateFormat166 = (new X264)->setKiloBitrate(250); // For 240p
            $lowBitrateFormat240 = (new X264)->setKiloBitrate(400); // For 240p
            $lowBitrateFormat360 = (new X264)->setKiloBitrate(800); // For 360p
            $midBitrateFormat480 = (new X264)->setKiloBitrate(1200); // For 480p
            $highBitrateFormat720 = (new X264)->setKiloBitrate(2000); // For 720p
            $hdBitrateFormat1080 = (new X264)->setKiloBitrate(4000); // For 1080p

            FFMpeg::fromDisk($this->video->disk)
                ->open($this->video->path)
                ->exportForHLS()
                ->toDisk(VideoDiskEnum::DISK->value)
                ->addFormat($lowBitrateFormat166, function($media) {
                    $media->scale(366, 166); // 166p
                })
                ->addFormat($lowBitrateFormat240, function($media) {
                    $media->scale(480, 270); // 270p
                })
                ->addFormat($lowBitrateFormat360, function($media) {
                    $media->scale(640, 360); // 360p
                })
                ->addFormat($midBitrateFormat480, function($media) {
                    $media->scale(854, 480); // 480p
                })
                ->addFormat($highBitrateFormat720, function($media) {
                    $media->scale(1280, 720); // 720p
                })
                ->addFormat($hdBitrateFormat1080, function($media) {
                    $media->scale(1920, 1080); // 1080p
                })
                // ->onProgress(function ($progress) {
                //     event(new JobProgress($this->video->id, $progress['percentage'], $this->totalSteps));
                // })
                ->save($this->basePath . $this->title . '/' . $this->video->uuid . '.m3u8');

            \Log::info('video converted into m3u8 successfully');
            $this->video->update([
                'converted_for_streaming_at' => Carbon::now()
            ]);   
        } catch (\Throwable $th) {
            \Log::error('Exception occurred: ' . $e->getMessage(), ['exception' => $e]);
        }
    }
}
