<?php

namespace Modules\User\Repositories\CuApi\V1;

use App\Exceptions\ApiErrorException;
use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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
            $user = $this->model->create(array_merge($array, ['phone_verified_at' => now(), 'password' => bcrypt($array['password'])]));
            $user->details()->create([
                'last_login_at' => now(),
                'fcm_token' => $array['fcm_token'],
                'device_info' => $array['device_info'],
            ]);
            $user->syncRoles('customer');
            $user->setAttribute('token', $user->createToken($array['phone'])->plainTextToken);
            DB::commit();
            return $user;
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
        DB::beginTransaction();
        try {
            $code = rand(1000, 9999);
            $this->OTPCode->where('phone', $array['phone'])->delete();
            $this->OTPCode->create([
                'phone' => $array['phone'], 'otp' => $code, 'expire_at' => Carbon::now()->addMinutes(2)
            ]);
            SendOTPCode::dispatch($array['phone'], $code);
            DB::commit();
            return true;
        } catch (\Exception $e){
            throw new ApiErrorException($e);
        }
    }

    public function verifyOtp($array): bool
    {
        $now = Carbon::now();
        $this->OTPCode = $this->OTPCode->where('phone', $array['phone'])->where('otp', $array['otp'])->first();
        if ($this->OTPCode && ! $now->isAfter($this->OTPCode->expire_at)){
            $this->OTPCode->where('phone', $array['phone'])->delete();
            return true;
        }
        return false;
    }
}
