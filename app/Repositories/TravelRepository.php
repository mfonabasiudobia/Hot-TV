<?php

namespace App\Repositories;

use App\Models\TravelPhoto;

/* This Repository contains or handles features that pertains to user traveling experience while streaming*/
class TravelRepository {

    public static function getCustomTravelPhotos(int $userId){
        return TravelPhoto::where('user_id', $userId);
    }

   public static function customImageUpload(array $data, int $userId){
        $path = "screenshots/$userId";

        return TravelPhoto::create(array_merge($data, [
            'image' => upload_file($data['image'], $path),
            'user_id' => $userId
        ]));
   }
   

}
