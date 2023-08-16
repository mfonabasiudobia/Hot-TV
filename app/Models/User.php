<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class User extends AuthenticatableBaseModel
{
    
    use SoftDeletes;
    
    protected $hidden = [
        'password',
        'remember_token',
        'email_verify_token',
        'confirmed_at',
        'description',
        'gender',
        'phone',
        'dob',
        'avatar_id',

        'super_user',
        'manage_supers',
        'permissions'
    ];

    protected $guarded = [];

    
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['is_verified'];

    public function getIsVerifiedAttribute(){
        return $this->email_verified_at ? true : false;
    }
}
