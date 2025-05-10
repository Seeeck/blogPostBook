<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    //{field}_confirmation para confirmar
    public function rules(): array
    {
        return [
            "name" => "required|min:5|unique:users|max:60",
            "email" => "required|unique:users|max:60",
            "password" => "required|min:5|max:60|confirmed",
            "password_confirmation" => "required|min:5|max:60"

        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es requerido',
            "name.min" => "Debe tener un mínimo de 5 carácteres",
            "name.max" => "Debe tener un máximo de 60 carácteres",
            "name.unique"=>"El nombre de usuario ya está registrado",
            "email.unique" => "El email ya esta registrado"
        ];
    }
}
