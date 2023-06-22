<?php

namespace Modules\User\Entities;

use App\Models\OverrideModel;
use Modules\User\Enums\GenderEnum;

/**
 * @property mixed $last_active_at
 * @property mixed $gender
 */

class UserDetails extends OverrideModel
{
    protected $table = 'user_details';

    protected $fillable = ['user_id', 'gender', 'birth_date', 'last_active_at', 'fcm_token', 'device_info', 'email_verified_at'];

    public $timestamps = false;

    protected $casts = ['user_id' => 'int', 'gender' => GenderEnum::class, 'birth_date' => 'datetime:Y-m-d', 'last_active_at' => 'datetime:Y-m-d H:i:s',];

    public function getGenderStringAttribute(): string
    {
        return $this->gender == GenderEnum::MALE ? 'male' : 'female';
    }

    public function getLastLoginHumanAttribute(): string
    {
        return $this->last_active_at->diffForHumans();
    }
}
