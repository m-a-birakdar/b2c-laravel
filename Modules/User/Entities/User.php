<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Cart\Entities\Cart;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use SoftDeletes, HasRoles, HasApiTokens;

    protected $table = 'users';

    protected $fillable = ['name', 'email', 'phone', 'password'];

    protected $casts = ['email_verified_at' => 'bool', 'phone_verified_at' => 'bool'];

    protected $hidden = ['password'];

    public function details(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(UserDetails::class);
    }

    public function cart(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Cart::class);
    }
}
