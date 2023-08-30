<?php

namespace App\Repositories;

use App\Models\VideoRequest;

class VideoRepository {

   public static function uploadVideo(array $data, int $userId){
        $videoPath = "video-request/$userId";
        $thumbnailPath = "video-request-thumbnail/$userId";

        return VideoRequest::create(array_merge($data, [
            'video_file' => upload_file($data['video_file'], $videoPath),
            'thumbnail' => upload_file($data['thumbnail'], $thumbnailPath),
            'user_id' => $userId
        ]));
   }

}
