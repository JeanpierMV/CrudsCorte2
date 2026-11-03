<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Compra extends Model
{
    protected $fillable = ['proveedor_id', 'insumo_id', 'cantidad', 'observacion', 'fecha'];

    protected function casts(): array
    {
        return ['cantidad' => 'decimal:2', 'fecha' => 'date'];
    }

    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function insumo(): BelongsTo
    {
        return $this->belongsTo(Insumo::class);
    }

    public function kardex(): HasOne
    {
        return $this->hasOne(Kardex::class);
    }

    /** Filtros: proveedor_id, insumo_id, desde, hasta (compartidos por listado y PDF). */
    public function scopeFiltrar(Builder $query, array $f): Builder
    {
        return $query
            ->when($f['proveedor_id'] ?? null, fn ($q, $v) => $q->where('proveedor_id', $v))
            ->when($f['insumo_id'] ?? null, fn ($q, $v) => $q->where('insumo_id', $v))
            ->when($f['desde'] ?? null, fn ($q, $v) => $q->whereDate('fecha', '>=', $v))
            ->when($f['hasta'] ?? null, fn ($q, $v) => $q->whereDate('fecha', '<=', $v));
    }
}
