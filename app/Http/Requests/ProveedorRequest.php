<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProveedorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // la autorización se controla con los middleware can: del controlador
    }

    public function rules(): array
    {
        return [
            'nombre'    => 'required|string|max:100',
            'telefono'  => ['required', 'regex:/^[0-9+\s-]{7,20}$/'],
            'correo'    => 'required|email|max:100',
            'direccion' => 'nullable|string|max:150',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required'   => 'El campo nombre es obligatorio.',
            'telefono.required' => 'El campo teléfono es obligatorio.',
            'telefono.regex'    => 'El teléfono solo puede tener números, espacios, + o - (entre 7 y 20 caracteres).',
            'correo.required'   => 'El campo correo es obligatorio.',
            'correo.email'      => 'El correo no tiene un formato válido.',
            'direccion.max'     => 'La dirección no puede superar los 150 caracteres.',
        ];
    }
}