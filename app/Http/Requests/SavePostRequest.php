<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SavePostRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            "mensaje" => "required|min:5|max:255",
        ];
    }

    public function messages(): array
    {
        return [
            'mensaje.required' => 'El mensaje es requerido',
            "mensaje.min" => "Debe tener un mínimo de 5 carácteres",
            "mensaje.max" => "Debe tener un máximo de 255 carácteres",
        ];
    }
}
