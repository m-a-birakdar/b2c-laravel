<?php

namespace Modules\User\Http\Controllers\CuApi\V1;

use App\Http\Resources\MainResource;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;
use Modules\User\Emails\CuApi\V1\ResetPasswordEmail;
use Modules\User\Repositories\CuApi\V1\UserRepository;
use Illuminate\Support\Facades\Mail;

class ResetPasswordController extends Controller
{
    /**
     * Create a new ResetPasswordController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function sendResetLinkEmail(Request $request): MainResource
    {
        $request->validate([
            'phone' => 'required|digits_between:10,16|regex:/(00)[0-9]/',
        ]);

        $user = (new UserRepository())->findWhere('phone', $request->phone, null, ['id', 'phone', 'email']);
        if (! $user) {
            return MainResource::make(null, false, tr('auth.this_phone_is_not_exists'), 404);
        }
        $token = $this->broker()->createToken($user);

        $resetUrl = URL::route('password.reset', [
            'token' => $token,
            'phone' => $user->phone,
            'email' => $user->email,
        ]);

        Mail::to($user->email)->send(new ResetPasswordEmail($resetUrl, $user));
        return MainResource::make(null, true, tr('auth.password_reset_email_sent'));
    }

    public function showResetForm()
    {
        return response()->json(['token' => \request()->all()], 200);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
            'token' => 'required|string',
        ]);

        $response = $this->broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        return $response == Password::PASSWORD_RESET
            ? response()->json(['message' => 'Password reset successfully.'], 200)
            : response()->json(['message' => 'Unable to reset password.'], 400);
    }

    public function broker()
    {
        return Password::broker();
    }

    protected function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);
        $user->save();
    }
}
