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
        $images = [];

        foreach($data['images'] as $image){
            $images[] = upload_file($image, $path);
        }

        return TravelPhoto::create(array_merge($data, [
            'images' => $images,
            'user_id' => $userId
        ]));
   }
   

}
