<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompraRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'proveedor_id' => 'required|exists:proveedores,id',
            'insumo_id'    => 'required|exists:insumos,id',
            'cantidad'     => 'required|numeric|gt:0',
            'observacion'  => 'nullable|string|max:200',
        ];
    }

    public function messages(): array
    {
        return [
            'proveedor_id.required' => 'Debes seleccionar un proveedor.',
            'proveedor_id.exists'   => 'El proveedor seleccionado no existe.',
            'insumo_id.required'    => 'Debes seleccionar un insumo.',
            'insumo_id.exists'      => 'El insumo seleccionado no existe.',
            'cantidad.required'     => 'El campo cantidad es obligatorio.',
            'cantidad.numeric'      => 'El campo cantidad debe ser numérico.',
            'cantidad.gt'           => 'El campo cantidad debe ser mayor que 0.',
            'observacion.max'       => 'La observación no puede superar los 200 caracteres.',
        ];
    }
}
