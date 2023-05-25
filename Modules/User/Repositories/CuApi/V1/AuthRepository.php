<?php

namespace Modules\User\Repositories\CuApi\V1;

use App\Exceptions\ApiErrorException;
use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Modules\Notification\Jobs\SendPrivateNotificationJob;
use Modules\User\Emails\CuApi\V1\VerifyEmail;
use Modules\User\Entities\OTPCode;
use Modules\User\Interfaces\CuApi\V1\AuthRepositoryInterface;
use Modules\User\Entities\User;
use Modules\User\Jobs\Cu\SendOTPCode;

class AuthRepository implements AuthRepositoryInterface
{
    use BaseRepositoryTrait;

    public User|null $model;

    public OTPCode|null $OTPCode;

    public function __construct(User $model = new User(), OTPCode $OTPCode = new OTPCode())
    {
        $this->model = $model;
        $this->OTPCode = $OTPCode;
    }

    public function login(User $user)
    {
        $user->details()->create([
            'last_login_at' => now()
        ]);
        SendPrivateNotificationJob::dispatch(nCu('user.login', 'title'), nCu('user.login'), $user);
        $user->setAttribute('token', $user->createToken($user->phone)->plainTextToken);
        return $user;
    }

    /**
     * @throws ApiErrorException
     */
    public function register($array)
    {
        DB::beginTransaction();
        try {
            $this->model = $this->model->create(array_merge($array, ['phone_verified_at' => now(), 'password' => bcrypt($array['password'])]));
            $this->model->details()->create([
                'last_login_at' => now(),
                'fcm_token' => $array['fcm_token'],
                'device_info' => $array['device_info'],
            ]);
            $this->model->syncRoles('customer');
            DB::commit();
            $this->model->setAttribute('token', $this->model->createToken($array['phone'])->plainTextToken);
            SendPrivateNotificationJob::dispatch(nCu('user.register', 'title'), nCu('user.register'), $this->model);
            return $this->model;
        } catch (\Exception $e){
            throw new ApiErrorException($e);
        }
    }

    public function logout()
    {
        return sanctum()->tokens()->delete();
    }

    public function existsForLogin($phone)
    {
        return $this->findWhere('phone', $phone, null, ['id', 'name', 'phone', 'password', 'status']);
    }

    public function sendOtp($array): bool
    {
        $code = rand(1000, 9999);
        DB::beginTransaction();
        try {
            $this->OTPCode->where('phone', $array['phone'])->delete();
            $this->OTPCode->create([
                'phone' => $array['phone'], 'otp' => $code, 'expire_at' => Carbon::now()->addMinutes(2)
            ]);
            DB::commit();
            SendOTPCode::dispatch($array['phone'], $code);
            return true;
        } catch (\Exception $e){
            throw new ApiErrorException($e);
        }
    }

    public function verifyOtp($array): bool
    {
        $this->OTPCode = $this->OTPCode->where('phone', $array['phone'])->where('otp', $array['otp'])->first();
        if ($this->OTPCode && ! Carbon::now()->isAfter($this->OTPCode->expire_at)){
            $this->OTPCode->where('phone', $array['phone'])->delete();
            return true;
        }
        return false;
    }

    public function verifyEmail($array): bool
    {
        $user = (new UserRepository())->findWhere('id', sanctum()->id, 'details:id,user_id,email_verified_at', ['id', 'email']);
        $token = hash_hmac('sha256', Str::random(40), $user->email);
        DB::beginTransaction();
        try {
            $user->details()->update([
                'email_verified_at' => null
            ]);
            DB::table('password_reset_tokens')->where('email', $user->email)->delete();
            DB::table('password_reset_tokens')->insert([
                'token' => $token,
                'email' => $user->email,
                'created_at' => now()
            ]);
            DB::commit();

            $resetUrl = URL::route('verify-email', [
                'token' => $token,
                'email' => $user->email,
            ]);

            Mail::to($user->email)->send(new VerifyEmail($resetUrl, $user));

            return true;
        } catch (\Exception $e){
            throw new ApiErrorException($e);
        }
    }

    public function verifyEmailToken($array): bool
    {
        $user = (new UserRepository())->findWhere('email', $array['email'], 'details:id,user_id,email_verified_at', ['id', 'email']);
        DB::beginTransaction();
        try {
            DB::table('password_reset_tokens')->where('email', $array['email'])->delete();
            $user->details()->update([
                'email_verified_at' => now()
            ]);
            DB::commit();
            SendPrivateNotificationJob::dispatch(nCu('user.verify_email', 'title'), nCu('user.verify_email'), $user);
            return true;
        } catch (\Exception $e){
            throw new ApiErrorException($e);
        }
    }
}
