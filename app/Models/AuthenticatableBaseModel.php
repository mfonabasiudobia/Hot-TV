<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class AuthenticatableBaseModel extends Authenticatable 
{

   use HasApiTokens, HasFactory, Notifiable, HasUuids;

   protected $guarded = [];
   
   public function createdAt(){
     return $this->created_at ? $this->created_at->format('d/M/Y') : null;
   }

   public function updatedAt(){
     return $this->updated_at ? $this->updated_at->format('d/M/Y') : null;
   }

   public function fullname(){
        return $this->first_name . ' ' . $this->last_name;
   }

   public function scopeActive($q){
        return $q->where('is_active', 1);
    }

    public function scopeInactive($q){
        return $q->where('is_active', 0);
    }


}
