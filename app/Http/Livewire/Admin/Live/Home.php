<?php

namespace App\Http\Livewire\Admin\Live;

use App\Http\Livewire\BaseComponent;
use App\Models\Stream;
use FFMpeg;
use FFMpeg\Format\Video\X264;
use App\Jobs\UploadVideo;

class Home extends BaseComponent
{
    public $video, $videos;

    public function mount(){
        $this->video = Stream::latest()->first();


        // dispatch(new UploadVideo);

        // $lowBitrate = (new X264)->setKiloBitrate(400); // Adjust the bitrate as needed for 360p
        // $midBitrate = (new X264)->setKiloBitrate(800); // Adjust the bitrate as needed for 480p
        // $highBitrate = (new X264)->setKiloBitrate(1500); // Adjust the bitrate as needed for 720p
        // $ultraBitrate = (new X264)->setKiloBitrate(3000); // Adjust the bitrate as needed for 1080p

        // FFMpeg::fromDisk('local')
        // ->open('halo.mp4')
        // ->exportForHLS()
        // ->setSegmentLength(10) // optional
        // ->setKeyFrameInterval(48) // optional
        // // ->addFormat($lowBitrate)
        // // ->addFormat($midBitrate)
        // // ->addFormat($highBitrate)
        // // ->addFormat($ultraBitrate)
        // ->save('adaptive_steve.m3u8');
    }

    public function render()
    {
        return view('livewire.admin.live.home')->layout('layouts.admin-base');
    }
}
