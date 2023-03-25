<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, SoftDeletes, HasRoles;

    protected $table = 'users';

    protected $fillable = ['name', 'email', 'phone', 'email_verified_at', 'phone_verified_at', 'password'];

    protected $casts = ['email_verified_at' => 'bool', 'phone_verified_at' => 'bool'];

    protected $hidden = ['password'];

    public function details(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(UserDetails::class);
    }

    protected static function newFactory(): \Modules\User\Database\factories\UserFactory
    {
        return \Modules\User\Database\factories\UserFactory::new();
    }
}
