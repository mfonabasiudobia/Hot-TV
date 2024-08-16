<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use App\Models\Podcast;
use App\Models\Shoutout;
use App\Models\VideoPlay;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use FFMpeg\FFMpeg;
use RuntimeException;


class VideoStreamOld2Controller extends Controller
{

    public function videoContent(Request $request, $section, $id)
    {

        $TIME_LIMIT = 600; // Time limit in seconds (e.g., 30 minutes)
        $user = Auth::user();
        $ipAddress = $request->ip();
        // Fetch the total played time for the user
        $userPlayback = VideoPlay::where('ip_address', $ipAddress)->first();

        $playedSeconds = $userPlayback ? $userPlayback->played_seconds : 0;

        if ($playedSeconds >= $TIME_LIMIT) {
            return response()->json(['error' => 'Playback time limit exceeded.'], 403);
        }

        // Determine the video path based on the section and ID
        switch ($section) {
            case 'episode':
                $recordedVideo = Episode::find($id)->recorded_video;
                break;
            case 'podcast':
                $recordedVideo = Podcast::find($id)->recorded_video;
                break;
            default:
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
            $durationInSeconds = $video->getFormat()->get('duration');
        } catch (RuntimeException $e) {
            return response()->json(['error' => 'FFmpeg or FFProbe not available'], 500);
        }

        $fileSize = filesize($videoPath);

        // Calculate the allowed length based on the remaining time
        $allowedSeconds = $TIME_LIMIT - $playedSeconds;
        $bytesPerSecond = $fileSize / $durationInSeconds;
        $maxBytes = min($fileSize, intval($bytesPerSecond * $allowedSeconds));

        $start = 0;
        $length = $maxBytes;
        $end = $start + $length - 1;

        $headers = [
            'Content-Type' => 'video/mp4',
            'Accept-Ranges' => 'bytes',
            'Content-Length' => $length,
            'Content-Range' => "bytes $start-$end/$fileSize",
        ];

        return response()->stream(function () use ($videoPath, $start, $length, $userPlayback, $user, $id, $ipAddress) {
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
                    \Log::info("Played seconds updated :". $userPlayback->played_seconds);
                } else {
                    VideoPlay::create([
                        'ip_address' => $ipAddress,
                        'played_seconds' => 1
                    ]);
                    \Log::info("Played seconds created 1");
                }

                $secondsStreamed += ($chunkSize / $length);
                \Log::info("Stream chunk size: ". $chunkSize);
                \Log::info("Second Stream: ". $secondsStreamed);
                sleep(1); // Simulate real-time second-by-second tracking
            }

            fclose($handle);
        }, 206, $headers);
    }

//    private function getVideoDuration($videoPath)
//    {
//        try {
//            $ffmpeg = FFMpeg::create();
//            $video = $ffmpeg->open($videoPath);
//            return $video->getFormat()->get('duration');
//        } catch (RuntimeException $e) {
//            return 0; // Return 0 in case of an error
//        }
//    }


    public function savePlayedTime(Request $request)
    {

        // Save the play information for guest users only

        if (!Auth::check()) {

            $request->validate([
                'played_seconds' => 'required|integer|min:1',
            ]);

            $ipAddress = $request->ip();
            $playedSeconds = $request->played_seconds;

            // Check if a record already exists for this IP, section, and video
            $existingPlay = VideoPlay::where('ip_address', $ipAddress)->first();

            if ($existingPlay) {
                // Update the existing record
                $existingPlay->played_seconds =  $playedSeconds;
                $existingPlay->save();
            } else {
                // Create a new record
                VideoPlay::create([
                    'ip_address' => $ipAddress,
                    'played_seconds' => $playedSeconds,
                ]);
            }
            \Log::info("Saved time as :". $playedSeconds);
        }

        return response()->json(['status' => 'success']);
    }
}
