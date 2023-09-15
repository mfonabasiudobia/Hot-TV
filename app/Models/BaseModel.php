<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class BaseModel extends Model
{

    use HasFactory;
    
    protected $guarded = [];

    public function createdAt(){
     return $this->created_at ? $this->created_at->format('M d, Y') : null;
   }

   public function updatedAt(){
     return $this->updated_at ? $this->updated_at->format('M d, Y') : null;
   }


}
