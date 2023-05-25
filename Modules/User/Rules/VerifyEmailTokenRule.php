<?php

namespace Modules\User\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class VerifyEmailTokenRule implements ValidationRule
{
    public string $email;

    public function __construct($email)
    {
        $this->email = $email;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $token = DB::table('password_reset_tokens')->where('email', $this->email)->where('token', $value)->first();
        if (is_null($token))
            $fail(tr('this_token_is_not_exists'));
        else {
            $expired = Carbon::createFromFormat('Y-m-d H:i:s', $token->created_at)->addMinutes(2);
            if (Carbon::now()->isAfter($expired))
                $fail(tr('this_token_is_expired'));
        }
    }
}
