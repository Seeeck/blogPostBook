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
            "nombre" => "required|min:5|max:255",
            "email" => "required|unique:users|max:60",
            "password"=>"required|min:5|max:60|confirmed"
   
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es requerido',
            "nombre.min" => "Debe tener un mínimo de 5 carácteres",
            "nombre.max" => "Debe tener un máximo de 60 carácteres",
            "email.unique"=>"Debe ser un email único"
        ];
    }
}
