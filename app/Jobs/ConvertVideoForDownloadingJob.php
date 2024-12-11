<?php

namespace App\Jobs;

use App\Enums\VideoDiskEnum;
use App\Models\Video;
use App\Events\JobProgress;
use Carbon\Carbon;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Illuminate\Support\Facades\Storage;

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
        try {
            $this->updateProgress(0);
            $fullPath = Storage::disk($this->video->disk)->url($this->video->path);

            $videoStream = FFMpeg::fromDisk($this->video->disk)
                ->open($this->video->path)
                ->getFFProbe()
                ->streams($fullPath)
                ->videos()
                ->first();

            $originalWidth = $videoStream->get('width');
            $originalHeight = $videoStream->get('height');

            $formats = [
                ['format' => (new X264)->setKiloBitrate(250), 'scale' => [366, 166]],
                ['format' => (new X264)->setKiloBitrate(400), 'scale' => [480, 270]],
                ['format' => (new X264)->setKiloBitrate(800), 'scale' => [640, 360]],
                ['format' => (new X264)->setKiloBitrate(1200), 'scale' => [854, 480]],
                ['format' => (new X264)->setKiloBitrate(2000), 'scale' => [1280, 720]],
                ['format' => (new X264)->setKiloBitrate(4000), 'scale' => [1920, 1080]],
            ];

            $filteredFormats = array_filter($formats, function ($config) use ($originalWidth, $originalHeight) {
                return $config['scale'][0] <= $originalWidth && $config['scale'][1] <= $originalHeight;
            });

            $exporter = FFMpeg::fromDisk($this->video->disk)
                ->open($this->video->path)
                ->export()
                ->toDisk(VideoDiskEnum::DISK->value);

            foreach ($filteredFormats as $index => $config) {
                $exporter->inFormat($config['format'])
                    ->addFilter(function($filters) use ($config) {
                        $filters->resize(new Dimension($config['scale'][0], $config['scale'][1]));
                    });

                $this->updateProgress(($index + 1) / count($formats) * 100);
            }

            $exporter->save($this->basePath . $this->title . '/' . $this->video->uuid . '_download.mp4');

            \Log::info('Video converted into mp4 successfully');
            $this->video->update([
                'converted_for_downloading_at' => Carbon::now()
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
