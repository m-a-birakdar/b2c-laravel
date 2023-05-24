<?php

namespace Modules\User\Entities;

use App\Traits\ScopeModels;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Address\Entities\Address;
use Modules\Cart\Entities\Cart;
use Modules\Wallet\Entities\Transaction;
use Modules\Wallet\Entities\Wallet;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Spatie\Permission\Traits\HasRoles;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements Auditable
{
    use SoftDeletes, HasRoles, HasApiTokens, AuditableTrait, Notifiable, ScopeModels;

    protected $table = 'users';

    protected $fillable = ['name', 'email', 'phone', 'password', 'status', 'phone_verified_at'];

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

    public function wallet(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Wallet::class);
    }

    public function transaction(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Transaction::class, 'sourceable');
    }

    public function addresses(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Address::class);
    }
}
