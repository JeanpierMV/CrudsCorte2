<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores'; // Laravel pluralizaría en inglés: se indica la tabla

    protected $fillable = ['nombre', 'telefono', 'correo', 'direccion'];

    /** Búsqueda por texto en nombre, correo o teléfono. */
    public function scopeFiltrar(Builder $query, array $f): Builder
    {
        return $query->when($f['q'] ?? null, function ($q, $v) {
            $q->where(function ($w) use ($v) {
                $w->where('nombre', 'like', "%{$v}%")
                  ->orWhere('correo', 'like', "%{$v}%")
                  ->orWhere('telefono', 'like', "%{$v}%");
            });
        });
    }

    /** Orden: nombre_asc | nombre_desc | recientes | (por defecto) id. */
    public function scopeOrdenarPor(Builder $query, ?string $orden): Builder
    {
        return match ($orden) {
            'nombre_asc'  => $query->orderBy('nombre'),
            'nombre_desc' => $query->orderByDesc('nombre'),
            'recientes'   => $query->orderByDesc('id'),
            default       => $query->orderBy('id'),
        };
    }
}