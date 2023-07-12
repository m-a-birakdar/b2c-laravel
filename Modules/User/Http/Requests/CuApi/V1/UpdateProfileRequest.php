<?php

namespace Modules\User\Http\Requests\CuApi\V1;

use App\Rules\Base64Image;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\User\Enums\GenderEnum;

class UpdateProfileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'nullable|email',
            'image_file' => ['nullable', new Base64Image],
            'gender' => 'nullable|' . Rule::in(array_column(GenderEnum::cases(), 'value')),
            'birth_date' => 'nullable|date',
        ];
    }

    public function authorize(): bool
    {
        return auth('sanctum')->check();
    }
}
