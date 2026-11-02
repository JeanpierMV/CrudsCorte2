<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InsumoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // la autorización se controla con los middleware can: del controlador
    }

    public function rules(): array
    {
        $id = $this->route('insumo')?->id;

        $reglas = [
            'nombre'            => ['required', 'string', 'max:100', Rule::unique('insumos', 'nombre')->ignore($id)],
            'unidad_medida'     => 'required|string|max:30',
            'stock_minimo'      => 'required|numeric|min:0',
            'fecha_vencimiento' => 'nullable|date',
        ];

        // El stock solo se captura al crear; después cambia únicamente por compras (kardex).
        if ($this->isMethod('post')) {
            $reglas['stock_actual'] = 'required|numeric|min:0';
        }

        return $reglas;
    }

    public function messages(): array
    {
        return [
            'nombre.required'        => 'El campo nombre es obligatorio.',
            'nombre.unique'          => 'Ya existe un insumo llamado ":input".',
            'unidad_medida.required' => 'La unidad de medida es obligatoria.',
            'stock_actual.required'  => 'El campo stock actual es obligatorio.',
            'stock_actual.numeric'   => 'El stock actual debe ser numérico.',
            'stock_actual.min'       => 'El stock actual no puede ser negativo.',
            'stock_minimo.required'  => 'El campo stock mínimo es obligatorio.',
            'stock_minimo.numeric'   => 'El stock mínimo debe ser numérico.',
            'stock_minimo.min'       => 'El stock mínimo no puede ser negativo.',
            'fecha_vencimiento.date' => 'La fecha de vencimiento no es válida (ej: 2026-12-31).',
        ];
    }
}
