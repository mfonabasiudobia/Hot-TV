<?php

namespace Botble\ACL\Models;

use App\Enums\User\RoleEnum;
use App\Models\Device;
use App\Models\Ride;
use App\Models\RideBooking;
use App\Models\DriverRideResponse;
use App\Models\VerificationDocument;
use Botble\ACL\Notifications\ResetPasswordNotification;
use Botble\ACL\Traits\PermissionTrait;
use Botble\Base\Casts\SafeContent;
use Botble\Base\Models\BaseModel;
use Botble\Base\Supports\Avatar;
use Botble\Media\Facades\RvMedia;
use Botble\Media\Models\MediaFile;
use Botble\SubscriptionPlan\Models\SubscriptionOrder;
use Exception;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Botble\Ecommerce\Models\Wishlist;
use Botble\Ecommerce\Models\Discount;
use Botble\Ecommerce\Models\Product;
use Botble\Ecommerce\Models\Review;
use Botble\Ecommerce\Models\Order;
use Botble\Ecommerce\Models\Address;
use Botble\Ecommerce\Models\Payment;

class User extends BaseModel implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable;
    use Authorizable;
    use CanResetPassword;
    use HasApiTokens;
    use HasFactory;
    use PermissionTrait;
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'username',
        'email',
        'first_name',
        'last_name',
        'password',
        'avatar_id',
        'permissions',
        'phone_number'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // protected $appends = ['avatar_url'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'permissions' => 'json',
        'username' => SafeContent::class,
        'first_name' => SafeContent::class,
        'last_name' => SafeContent::class,
    ];

    protected function firstName(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucfirst((string)$value),
            set: fn ($value) => ucfirst((string)$value),
        );
    }

    protected function lastName(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucfirst((string)$value),
            set: fn ($value) => ucfirst((string)$value),
        );
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->first_name . ' ' . $this->last_name,
        );
    }

    protected function activated(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->activations()->where('completed', true)->exists(),
        );
    }

    protected function avatarUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                // dd($this->avatar());
                if (!empty($this->avatar()->url) ) {
                    return RvMedia::url($this->avatar()->url);
                }

                try {
                    return (new Avatar())->create($this->name)->toBase64();
                } catch (Exception) {
                    return RvMedia::getDefaultImage();
                }
            },
        );
    }

    // protected function getAvatarUrlAttribute(): Attribute
    // {
    //     return Attribute::make(
    //         get: function () {

    //             if (!empty($this->avatar()->url) ) {
    //                 return RvMedia::url($this->avatar()->url);
    //             }

    //             try {
    //                 return (new Avatar())->create($this->name)->toBase64();
    //             } catch (Exception) {
    //                 return RvMedia::getDefaultImage();
    //             }
    //         },
    //     );
    // }

    public function verification_documents(): HasMany
    {
        return $this->hasMany(VerificationDocument::class, 'user_id');
    }

    public function avatar()
    {
        // dd($this->avatar_id);
        return MediaFile::where('id', $this->avatar_id)->first();


        //return $this->belongsTo(MediaFile::class)->withDefault();
    }

    public function roles(): BelongsToMany
    {
        return $this
            ->belongsToMany(Role::class, 'role_users', 'user_id', 'role_id')
            ->withTimestamps();
    }

    public function isSuperUser(): bool
    {
        return $this->super_user || $this->hasAccess(ACL_ROLE_SUPER_USER);
    }

    public function hasPermission(string $permission): bool
    {
        if ($this->isSuperUser()) {
            return true;
        }

        return $this->hasAccess($permission);
    }

    public function hasAnyPermission(array $permissions): bool
    {
        if ($this->isSuperUser()) {
            return true;
        }

        return $this->hasAnyAccess($permissions);
    }


    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function activations(): HasMany
    {
        return $this->hasMany(Activation::class, 'user_id');
    }

    public function inRole($role): bool
    {
        $roleId = null;
        if ($role instanceof Role) {
            $roleId = $role->getKey();
        }

        foreach ($this->roles as $instance) {
            if ($role instanceof Role) {
                if ($instance->getKey() === $roleId) {
                    return true;
                }
            } elseif ($instance->getKey() == $role || $instance->slug == $role) {
                return true;
            }
        }

        return false;
    }

    public function delete(): bool|null
    {
        if ($this->exists) {
            $this->activations()->delete();
            $this->roles()->detach();
        }

        return parent::delete();
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }

    public function addresses(): HasMany
    {
        $with = [];
        if (is_plugin_active('location')) {
            $with = ['locationCountry', 'locationState', 'locationCity'];
        }

        return $this->hasMany(Address::class, 'customer_id', 'id')->with($with);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'customer_id', 'id');
    }

    public function discounts(): BelongsToMany
    {
        return $this->belongsToMany(Discount::class, 'ec_discount_customers', 'customer_id', 'id');
    }

    public function wishlist(): HasMany
    {
        return $this->hasMany(Wishlist::class, 'customer_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'customer_id');
    }


    public function viewedProducts(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'ec_customer_recently_viewed_products');
    }

    public function usedCoupons(): BelongsToMany
    {
        return $this->belongsToMany(Discount::class, 'ec_customer_used_coupons');
    }

    public function rides(): HasMany
    {
        if($this->inRole(RoleEnum::DRIVER->value)) {
            return $this->hasMany(Ride::class, 'driver_id');
        }
        return $this->hasMany(Ride::class)->whereRaw('1 = 0');
    }

    public function rideBookings(): HasMany
    {
        if($this->inRole(RoleEnum::SUBSCRIBER->value)) {
            return $this->hasMany(RideBooking::class);
        }
        return $this->hasMany(RideBooking::class)->whereRaw('1 = 0');
    }

    public function subscription(): HasOne
    {
        return $this->hasOne(SubscriptionOrder::class)->where('current_subscription', true);
    }

    public function myRides(): HasMany
    {
        if($this->inRole(RoleEnum::SUBSCRIBER->value)) {
            return $this->hasMany(Ride::class, 'user_id');
        }
        return $this->hasMany(Ride::class)->whereRaw('1 = 0');
    }

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class);
    }

    public function ride_responses(): HasMany
    {
        return $this->hasMany(DriverRideResponse::class, 'driver_id', 'id');
    }

    public function hasDevice($deviceId): bool
    {
        return $this->devices()->where('device_id', $deviceId)->exists();
    }

    public function hasRideEntry($ride): bool
    {
        return $this->ride_responses()->where('ride_id', $ride->id)->exists();
    }

    public function hasRejectedRide($ride): bool
    {
        return $this->ride_responses()->where('ride_id', $ride->id)->where('status', 'rejected')->exists();
    }

    public function hasAcceptedRide($ride): bool
    {
        return $this->ride_responses()->where('ride_id', $ride->id)->where('status', 'accepted')->exists();
    }

    public function hasPendingRide($ride): bool
    {
        return $this->ride_responses()->where('ride_id', $ride->id)->where('status', 'pending')->exists();
    }
}
