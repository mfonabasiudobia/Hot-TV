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


class VideoStreamController extends Controller
{

    public function videoContent(Request $request, $section, $id)
    {
        $ipAddress = $request->ip();
        $existingPlay = VideoPlay::where('ip_address', $ipAddress)->first();

        if($existingPlay && $existingPlay->played_seconds < 600) {
            abort(404, 'Video not found');
        }

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

        $fileSize = filesize($videoPath);

        // Return the full video content
        return response()->stream(function () use ($videoPath) {
            $handle = fopen($videoPath, 'rb');
            echo fread($handle, filesize($videoPath));
            fclose($handle);
        }, 200, [
            'Content-Type' => 'video/mp4',
            'Content-Length' => $fileSize,
            'Accept-Ranges' => 'bytes',
        ]);
    }

    private function getVideoDuration($videoPath)
    {
        try {
            $ffmpeg = FFMpeg::create();
            $video = $ffmpeg->open($videoPath);
            return $video->getFormat()->get('duration');
        } catch (RuntimeException $e) {
            return 0; // Return 0 in case of an error
        }
    }


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
