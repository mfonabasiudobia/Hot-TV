<?php

namespace App\Http\Livewire\Admin\Live;

use App\Http\Livewire\BaseComponent;
use App\Models\Stream;
use FFMpeg;
use FFMpeg\Format\Video\X264;

class Home extends BaseComponent
{

    public $video, $videos;

    public function mount(){
        $this->video = Stream::latest()->first();

        // dd(12440);

        $lowBitrate = (new X264)->setKiloBitrate(250);
        $midBitrate = (new X264)->setKiloBitrate(500);
        $highBitrate = (new X264)->setKiloBitrate(1000);

        FFMpeg::fromDisk('videos')
        ->open('steve_howe.mp4')
        ->exportForHLS()
        ->setSegmentLength(10) // optional
        ->setKeyFrameInterval(48) // optional
        ->addFormat($lowBitrate)
        ->addFormat($midBitrate)
        ->addFormat($highBitrate)
        ->save('adaptive_steve.m3u8');
    }

    public function render()
    {
        return view('livewire.admin.live.home')->layout('layouts.admin-base');
    }
}
