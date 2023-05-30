<?php

namespace Modules\User\Http\Requests\CuApi\V1;

use App\Exceptions\MainException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Modules\User\Entities\User;
use Modules\User\Interfaces\CuApi\V1\AuthRepositoryInterface;

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
        parent::__construct();
        $this->authRepository = $authRepository;
    }

    /**
     * @throws MainException
     */
    public function passedValidation()
    {
        $this->user = $this->authRepository->existsForLogin($this->input('phone'));
        if (is_null($this->user))
            throw new MainException(false, tr('check_phone'), 422);
        if (! Hash::check($this->input('password'), $this->user->password))
            throw new MainException(false, tr('check_password'), 422);
        if (! $this->user->hasRole('customer'))
            throw new MainException(false, tr('auth.you_dont_have_permission'), 422);
        if (! $this->user->status)
            throw new MainException(false, tr('account_is_not_available_now'), 422);
    }

    public function rules(): array
    {
        return [
            'id'        => 'required|integer|exists:users',
            'phone'     => 'required|digits_between:10,16|regex:/(00)[0-9]/',
            'password'  => 'required'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
