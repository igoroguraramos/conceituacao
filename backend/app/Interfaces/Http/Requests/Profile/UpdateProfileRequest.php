<?php

namespace App\Interfaces\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $profile = $this->route('profile');

        return [
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
            ],
            'slug' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('profiles', 'slug')->ignore($profile->id),
            ],
            'description' => [
                'sometimes',
                'nullable',
                'string',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'slug.unique' => 'O slug informado já está em uso por outro perfil.',
        ];
    }
}