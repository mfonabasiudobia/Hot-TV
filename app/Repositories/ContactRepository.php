<?php

namespace App\Repositories;

use App\Models\Contact;

class ContactRepository {

   public static function create(array $data){
        return Contact::create($data);
   }

}
