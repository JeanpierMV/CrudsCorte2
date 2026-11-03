<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kardex extends Model
{
    protected $table = 'kardex';

    protected $fillable = [
        'compra_id', 'insumo_id', 'tipo', 'cantidad',
        'stock_anterior', 'stock_nuevo', 'fecha_movimiento',
    ];

    protected function casts(): array
    {
        return [
            'cantidad'         => 'decimal:2',
            'stock_anterior'   => 'decimal:2',
            'stock_nuevo'      => 'decimal:2',
            'fecha_movimiento' => 'date',
        ];
    }

    public function compra(): BelongsTo
    {
        return $this->belongsTo(Compra::class);
    }

    public function insumo(): BelongsTo
    {
        return $this->belongsTo(Insumo::class);
    }

    /** Filtros: insumo_id, desde, hasta. */
    public function scopeFiltrar(Builder $query, array $f): Builder
    {
        return $query
            ->when($f['insumo_id'] ?? null, fn ($q, $v) => $q->where('insumo_id', $v))
            ->when($f['desde'] ?? null, fn ($q, $v) => $q->whereDate('fecha_movimiento', '>=', $v))
            ->when($f['hasta'] ?? null, fn ($q, $v) => $q->whereDate('fecha_movimiento', '<=', $v));
    }
}
