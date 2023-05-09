<?php

namespace Modules\User\Repositories\CuApi\V1;

use App\Exceptions\ApiErrorException;
use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Illuminate\Support\Facades\DB;
use Modules\User\Interfaces\CuApi\V1\AuthRepositoryInterface;
use Modules\User\Entities\User;

class AuthRepository implements AuthRepositoryInterface
{
    use BaseRepositoryTrait;

    public User|null $model;

    public function __construct(User $model)
    {
        $this->model = $model;
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
            $user = $this->model->create($array);
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
}
