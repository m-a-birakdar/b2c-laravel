<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Enums\GenderEnum;

class UserDetails extends Model
{
    use HasFactory;

    protected $table = 'user_details';

    protected $fillable = ['user_id', 'gender', 'birth_date', 'last_login_at', 'fcm_token', 'device_info'];

//    protected $appends = ['gender_string', 'last_login_human'];

    protected $casts = ['user_id' => 'int', 'gender' => GenderEnum::class, 'birth_date' => 'datetime:Y-m-d', 'last_login_at' => 'datetime:Y-m-d H:i:s',];

    public function getGenderStringAttribute(): string
    {
        return $this->gender == GenderEnum::MALE ? 'male' : 'female';
    }

    public function getLastLoginHumanAttribute(): string
    {
        return $this->last_login_at->diffForHumans();
    }

    public $timestamps = false;

    protected static function newFactory(): \Modules\User\Database\factories\UserDetailsFactory
    {
        return \Modules\User\Database\factories\UserDetailsFactory::new();
    }
}
