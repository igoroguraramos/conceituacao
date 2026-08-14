<?php

namespace App\Interfaces\Http\Requests\UserProfile;

use Illuminate\Foundation\Http\FormRequest;

class SyncUserProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'profiles' => ['required', 'array'],
            'profiles.*' => ['integer', 'exists:profiles,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'profiles.required' => 'O campo de perfis é obrigatório.',
            'profiles.array' => 'O campo de perfis deve ser um array.',
            'profiles.*.integer' => 'Cada perfil deve ser um número inteiro.',
            'profiles.*.exists' => 'Um ou mais perfis fornecidos não existem.',
        ];
    }
}