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
        try {
            $this->updateProgress(0);

            $formats = [
                ['format' => (new X264)->setKiloBitrate(500), 'scale' => [960, 540]],
                ['format' => (new X264)->setKiloBitrate(1500), 'scale' => [1280, 720]],
                ['format' => (new X264)->setKiloBitrate(3000), 'scale' => [1920, 1080]],
            ];

            $exporter = FFMpeg::fromDisk($this->video->disk)
                ->open($this->video->path)
                ->addFilter(function($filters) {
                    $filters->resize(new Dimension(960, 540));
                })
                ->export()
                ->toDisk(VideoDiskEnum::DISK->value);

            foreach ($formats as $index => $config) {
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
