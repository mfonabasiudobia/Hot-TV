<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use App\Models\Podcast;
use App\Models\Shoutout;
use Illuminate\Support\Facades\Auth;
use FFMpeg\FFMpeg;
use RuntimeException;


class VideoStreamController extends Controller
{

    public function __invoke($section, $id)
    {


        switch($section){
            case 'episode':
                $recordedVideo = Episode::find($id)->recorded_video;
                break;
            case 'podcast':
                $recordedVideo = Podcast::find($id)->recorded_video;
                break;

            default;
                $recordedVideo = Shoutout::find($id)->media_url;
                break;
        }


        $videoPath = __DIR__ . '/../../../public/storage/' . $recordedVideo;

        if (!file_exists($videoPath)) {
            abort(404, 'Video not found');
        }

        try {
            $ffmpeg = FFMpeg::create();
            $video = $ffmpeg->open($videoPath);
        } catch (RuntimeException $e) {
            return response()->json(['error' => 'FFmpeg or FFProbe not available'], 500);
        }

        $durationInSeconds = $video->getFormat()->get('duration');
        $fileSize = filesize($videoPath);
        $bytesPerSecond = $fileSize / $durationInSeconds;

        if (!Auth::check()) {
            $videoLength = setting('video_length');
            $maxSeconds = $videoLength;
            $maxBytes = intval($bytesPerSecond * $maxSeconds);
            $maxBytes = min($maxBytes, $fileSize);

        } else {
            $maxBytes = $fileSize;
        }

        $start = 0;
        $length = $maxBytes;
        $end = $start + $length - 1;

        $headers = [
            'Content-Type' => 'video/mp4',
            'Accept-Ranges' => 'bytes',
            'Content-Length' => $length,
            'Content-Range' => "bytes $start-$end/$fileSize",
        ];

        return response()->stream(function () use ($videoPath, $start, $length) {
            $handle = fopen($videoPath, 'rb');
            fseek($handle, $start);
            echo fread($handle, $length);
            fclose($handle);
        }, 206, $headers);

    }
}
