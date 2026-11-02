<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    use HasFactory;

    protected $table = 'insumos';

    protected $fillable = [
        'nombre', 'unidad_medida', 'stock_actual', 'stock_minimo', 'fecha_vencimiento',
    ];

    protected function casts(): array
    {
        return [
            'stock_actual'      => 'decimal:2',
            'stock_minimo'      => 'decimal:2',
            'fecha_vencimiento' => 'date',
        ];
    }

    /** Un insumo está en alerta cuando el stock actual es menor o igual al mínimo. */
    public function getStockBajoAttribute(): bool
    {
        return (float) $this->stock_actual <= (float) $this->stock_minimo;
    }

    /** Filtros compartidos por el listado y por el PDF: q, unidad, estado (bajo|ok). */
    public function scopeFiltrar(Builder $query, array $f): Builder
    {
        return $query
            ->when($f['q'] ?? null, fn ($q, $v) => $q->where('nombre', 'like', "%{$v}%"))
            ->when($f['unidad'] ?? null, fn ($q, $v) => $q->where('unidad_medida', $v))
            ->when(($f['estado'] ?? null) === 'bajo', fn ($q) => $q->whereColumn('stock_actual', '<=', 'stock_minimo'))
            ->when(($f['estado'] ?? null) === 'ok', fn ($q) => $q->whereColumn('stock_actual', '>', 'stock_minimo'));
    }
}
