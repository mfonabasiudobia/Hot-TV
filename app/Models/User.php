<?php

namespace App\Models;

use Botble\Base\Supports\Avatar;
use Botble\Media\Facades\RvMedia;
use Botble\Media\Models\MediaFile;
use Exception;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'permissions',
        'stripe_customer_id'
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
    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }
    
    protected function avatarUrl(): Attribute
    {
        return Attribute::make(
            get: function () {

                if (!empty($this->avatar->url) ) {
                    return RvMedia::url($this->avatar->url);
                }

                try {
                    return (new Avatar())->create($this->name)->toBase64();
                } catch (Exception) {
                    return RvMedia::getDefaultImage();
                }
            },
        );
    }

    public function mediaFile()
    {
        $mediaFile = MediaFile::where('id', $this->avatar_id)->get();

        dd($mediaFile);
        //return $this->belongsTo(MediaFile::class)->withDefault();
    }
}
