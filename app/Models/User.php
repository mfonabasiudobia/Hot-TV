<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Botble\ACL\Models\Role;
use Botble\ACL\Models\Activation;

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

    protected $appends = ['is_verified', 'fullname'];

    public function roles()
    {
        return $this
            ->belongsToMany(Role::class, 'role_users', 'user_id', 'role_id')
            ->withTimestamps();
    }

    public function activations()
    {
        return $this->hasMany(Activation::class, 'user_id');
    }

    public function getIsVerifiedAttribute(){
        return $this->email_verified_at ? true : false;
    }

    public function getFullnameAttribute(){
        return "$this->first_name $this->last_name";
    }
}
