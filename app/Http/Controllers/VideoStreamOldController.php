<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use App\Models\Podcast;
use App\Models\Shoutout;
use App\Models\VideoPlay;
use Illuminate\Support\Facades\Auth;
use FFMpeg\FFMpeg;
use RuntimeException;


class VideoStreamOldController extends Controller
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
        $ipAddress = $request->ip();
        $existingPlay = VideoPlay::where('ip_address', $ipAddress)->first();

        if($existingPlay && $existingPlay->played_seconds < 600) {
            abort(404, 'Video not found');
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
            $chunkSize = 1024 * 1024; // 1MB chunks
            $secondsStreamed = 0;

            while (!feof($handle) && $secondsStreamed < $length) {
                echo fread($handle, $chunkSize);
                ob_flush();
                flush();

                // Increment the played time by one second for each chunk streamed
                if ($userPlayback) {
                    $userPlayback->played_seconds += 1;
                    $userPlayback->save();
                } else {
                    UserPlayback::create([
                        'user_id' => $user->id,
                        'video_id' => $id,
                        'played_seconds' => 1
                    ]);
                }

                $secondsStreamed += ($chunkSize / $length);
                sleep(1); // Simulate real-time second-by-second tracking
            }
            fclose($handle);

//            $handle = fopen($videoPath, 'rb');
//            fseek($handle, $start);
//            echo fread($handle, $length);
//            fclose($handle);
        }, 206, $headers);

    }
}
