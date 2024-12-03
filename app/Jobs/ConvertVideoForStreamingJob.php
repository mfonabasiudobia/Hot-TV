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
            ->toDisk('s3'); // Replace with your actual disk
            toast()
                ->info('Job With ID' . $this->job->getJobId() . 'In Progress')
                ->push();
            foreach ($formats as $index => $config) {
                $hlsExporter->addFormat($config['format'], function ($media) use ($config) {
                    $media->scale($config['scale'][0], $config['scale'][1]);
                });

                // Simulate progress step
                $this->updateProgress(($index + 1) / $this->steps * 100);
            }

            $hlsExporter->save($this->basePath . $this->title . '/' . $this->video->uuid . '.m3u8');

            $this->updateProgress(100); // Mark job as completed
            // $lowBitrateFormat166 = (new X264)->setKiloBitrate(250); // For 240p
            // $lowBitrateFormat240 = (new X264)->setKiloBitrate(400); // For 240p
            // $lowBitrateFormat360 = (new X264)->setKiloBitrate(800); // For 360p
            // $midBitrateFormat480 = (new X264)->setKiloBitrate(1200); // For 480p
            // $highBitrateFormat720 = (new X264)->setKiloBitrate(2000); // For 720p
            // $hdBitrateFormat1080 = (new X264)->setKiloBitrate(4000); // For 1080p

            // FFMpeg::fromDisk($this->video->disk)
            //     ->open($this->video->path)
            //     ->exportForHLS()
            //     ->toDisk(VideoDiskEnum::DISK->value)
            //     ->addFormat($lowBitrateFormat166, function($media) {
            //         $media->scale(366, 166); // 166p
            //     })
            //     ->addFormat($lowBitrateFormat240, function($media) {
            //         $media->scale(480, 270); // 270p
            //     })
            //     ->addFormat($lowBitrateFormat360, function($media) {
            //         $media->scale(640, 360); // 360p
            //     })
            //     ->addFormat($midBitrateFormat480, function($media) {
            //         $media->scale(854, 480); // 480p
            //     })
            //     ->addFormat($highBitrateFormat720, function($media) {
            //         $media->scale(1280, 720); // 720p
            //     })
            //     ->addFormat($hdBitrateFormat1080, function($media) {
            //         $media->scale(1920, 1080); // 1080p
            //     })
            //     ->onProgress(function ($progress) {
            //         \Log('progress upated', $this->job->getJobId());
            //         event(new JobProgress($$this->job->getJobId(), $progress['percentage']));
            //     })
            //     ->save($this->basePath . $this->title . '/' . $this->video->uuid . '.m3u8');

            \Log::info('video converted into m3u8 successfully');
            $this->video->update([
                'converted_for_streaming_at' => Carbon::now()
            ]);
        } catch (\Throwable $th) {
            \Log::error('Exception occurred: ' . $th->getMessage(), ['exception' => $th]);
        }
    }

    protected function updateProgress(float $percentage): void
    {
        Cache::put("job_progress_{$this->job->getJobId()}", $percentage, 3600);

        // Broadcast progress event
        event(new JobProgress($this->job->getJobId(), $percentage));
    }
}
