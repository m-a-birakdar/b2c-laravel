<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;

class OTPCode extends Model
{
    protected $table = 'otp_codes';

    protected $fillable = ['phone', 'otp', 'expire_at'];
}
