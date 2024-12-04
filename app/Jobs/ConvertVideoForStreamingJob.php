<?php

namespace App\Jobs;

use App\Enums\VideoDiskEnum;
use App\Models\Video;
use App\Events\JobProgress;
use Carbon\Carbon;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Illuminate\Support\Facades\Cache;

class ConvertVideoForStreamingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $basePath;
    public $video;
    public $title;

    protected $steps = 6;

    public function __construct($basePath, Video $video, string $title)
    {
        $this->basePath = $basePath;
        $this->video = $video;
        $this->title = $title;
    }

    public function handle(): void
    {
        try {
            $this->updateProgress(0); // Initialize progress

            $formats = [
                ['format' => (new X264)->setKiloBitrate(250), 'scale' => [366, 166]],
                ['format' => (new X264)->setKiloBitrate(400), 'scale' => [480, 270]],
                ['format' => (new X264)->setKiloBitrate(800), 'scale' => [640, 360]],
                ['format' => (new X264)->setKiloBitrate(1200), 'scale' => [854, 480]],
                ['format' => (new X264)->setKiloBitrate(2000), 'scale' => [1280, 720]],
                ['format' => (new X264)->setKiloBitrate(4000), 'scale' => [1920, 1080]],
            ];

            $hlsExporter = FFMpeg::fromDisk($this->video->disk)
            ->open($this->video->path)
            ->exportForHLS()
            ->toDisk('s3');

            foreach ($formats as $index => $config) {
                $hlsExporter->addFormat($config['format'], function ($media) use ($config) {
                    $media->scale($config['scale'][0], $config['scale'][1]);
                });

                // Simulate progress step
                $this->updateProgress(($index + 1) / $this->steps * 100);
            }

            $hlsExporter->save($this->basePath . $this->title . '/' . $this->video->uuid . '.m3u8');

            \Log::info('video converted into m3u8 successfully');
            $this->video->update([
                'converted_for_streaming_at' => Carbon::now()
            ]);
            $this->updateProgress(100);
        } catch (\Throwable $th) {
            \Log::error('Exception occurred: ' . $th->getMessage(), ['exception' => $th]);
        }
    }

    protected function updateProgress(float $percentage): void
    {
        $title = 'Podcast: ' . $this->title;
        event(new JobProgress($this->job->getJobId(), $percentage, $title));
    }
}
