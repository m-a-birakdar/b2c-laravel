<?php

namespace Modules\User\Http\Requests\Api\V1;

use App\Exceptions\MainException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Modules\User\Entities\User;
use Modules\User\Interfaces\Api\V1\AuthRepositoryInterface;

/**
 * @property mixed $password
 * @property mixed $phone
 */

class LoginRequest extends FormRequest
{
    private AuthRepositoryInterface $authRepository;
    public User|null $user;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    /**
     * @throws MainException
     */
    public function passedValidation()
    {
        $this->user = $this->authRepository->existsForLogin($this->input('phone'));
        if (is_null($this->user))
            throw new MainException(false, 'تأكد من رقم الهاتف وكلمة السر', 422);
        if (! Hash::check($this->input('password'), $this->user->password))
            throw new MainException(false, 'تأكد من كلمة السر', 422);
        if (! $this->user->status)
            throw new MainException(false, 'الحساب غير متاح حالياً', 422);
    }

    public function rules(): array
    {
        return [
            'phone' => 'required|digits_between:10,16|regex:/(00)[0-9]/',
            'password' => 'required'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
