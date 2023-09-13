<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use FFMpeg;
use FFMpeg\Format\Video\X264;

class UploadVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    public function handle()
    {
        $lowBitrate = (new X264)->setKiloBitrate(400); // Adjust the bitrate as needed for 360p
        $midBitrate = (new X264)->setKiloBitrate(800); // Adjust the bitrate as needed for 480p
        $highBitrate = (new X264)->setKiloBitrate(1500); // Adjust the bitrate as needed for 720p
        $ultraBitrate = (new X264)->setKiloBitrate(3000); // Adjust the bitrate as needed for 1080p

        FFMpeg::fromDisk('local')
        ->open('halo.mp4')
        ->exportForHLS()
        ->setSegmentLength(10) // optional
        ->setKeyFrameInterval(48) // optional
        ->addFormat($lowBitrate)
        ->addFormat($midBitrate)
        ->addFormat($highBitrate)
        ->addFormat($ultraBitrate)
        ->save('adaptive_steve.m3u8');
    }
}
