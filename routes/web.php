<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    require __DIR__.'/insumos.php';
    require __DIR__.'/compras.php';
});