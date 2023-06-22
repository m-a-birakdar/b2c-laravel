<?php

namespace Modules\User\Repositories\CuApi\V1;

use App\Repositories\DBTransactionRepository;
use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Modules\Notification\Jobs\SendPrivateNotificationJob;
use Modules\User\Emails\CuApi\V1\VerifyEmail;
use Modules\User\Entities\OTPCode;
use Modules\User\Interfaces\CuApi\V1\AuthRepositoryInterface;
use Modules\User\Entities\User;
use Modules\User\Jobs\Cu\SendOTPCode;
use Modules\Whatsapp\Enums\PriorityEnum;
use Modules\Whatsapp\Repositories\Web\WhatsappRepository;

class AuthRepository extends DBTransactionRepository implements AuthRepositoryInterface
{
    use BaseRepositoryTrait;

    public User|null $model;

    public OTPCode|null $OTPCode;

    public function __construct(User $model = new User(), OTPCode $OTPCode = new OTPCode())
    {
        $this->model = $model;
        $this->OTPCode = $OTPCode;
    }

    public function welcome($array): ?User
    {
        $this->executeInTransaction(function () use ($array) {
            $this->model = $this->model->create();
            $this->model->details()->create([
                'last_active_at' => now(),
                'fcm_token' => $array['fcm_token'],
                'device_info' => $array['device_info'],
            ]);
            $this->model->syncRoles('customer');
        });
        return $this->model;
    }

    public function login(User $user): User
    {
        $user->details()->update([
            'last_active_at' => now()
        ]);
        SendPrivateNotificationJob::dispatch(nCu('user.login', 'title'), nCu('user.login'), $user);
        $user->setAttribute('token', $user->createToken($user->phone)->plainTextToken);
        return $user;
    }

    public function register($array): ?User
    {
        $this->find($array['id']);
        $this->executeInTransaction(function () use ($array) {
            $this->model->update(array_merge($array, ['phone_verified_at' => now(), 'password' => bcrypt($array['password'])]));
            $this->model->details()->update([
                'last_active_at' => now(),
            ]);
            $this->model->syncRoles('customer');
        });
        $this->model->setAttribute('token', $this->model->createToken($array['phone'])->plainTextToken);
        SendPrivateNotificationJob::dispatch(nCu('user.register', 'title'), nCu('user.register'), $this->model);
        return $this->model;
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
        $this->executeInTransaction(function () use ($array, $code) {
            $this->OTPCode->where('phone', $array['phone'])->delete();
            $this->OTPCode->create([
                'phone' => $array['phone'], 'otp' => $code, 'expire_at' => Carbon::now()->addMinutes(2)
            ]);
            ( new WhatsappRepository )->store([
                'priority' => PriorityEnum::HIGH->value, 'phone' => preg_replace('/00/', '', $array['phone'], 1), 'message' => 'otp message',
            ]);
        });
        SendOTPCode::dispatch($array['phone'], $code);
        return true;
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
        $this->model = ( new UserRepository() )->findWhere('id', sanctum()->id, 'details:id,user_id,email_verified_at', ['id', 'email']);
        $token = hash_hmac('sha256', Str::random(40), $this->model->email);
        $this->executeInTransaction(function () use ($token) {
            $this->model->details()->update([
                'email_verified_at' => null
            ]);
            DB::table('password_reset_tokens')->where('email', $this->model->email)->delete();
            DB::table('password_reset_tokens')->insert([
                'token' => $token,
                'email' => $this->model->email,
                'created_at' => now()
            ]);
        });
        $resetUrl = URL::route('verify-email', [
            'token' => $token,
            'email' => $this->model->email,
        ]);
        Mail::to($this->model->email)->send(new VerifyEmail($resetUrl, $this->model));
        return true;
    }

    public function verifyEmailToken($array): bool
    {
        $this->model = ( new UserRepository() )->findWhere('email', $array['email'], 'details:id,user_id,email_verified_at', ['id', 'email']);
        $this->executeInTransaction(function () use ($array) {
            DB::table('password_reset_tokens')->where('email', $array['email'])->delete();
            $this->model->details()->update([
                'email_verified_at' => now()
            ]);
        });
        SendPrivateNotificationJob::dispatch(nCu('user.verify_email', 'title'), nCu('user.verify_email'), $this->model);
        return true;
    }
}
