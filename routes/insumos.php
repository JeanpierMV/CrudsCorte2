<?php

use App\Http\Controllers\InsumoController;
use App\Http\Controllers\InsumoPdfController;
use Illuminate\Support\Facades\Route;

// Se incluye desde routes/web.php dentro del grupo con middleware 'auth'.
Route::get('insumos/pdf', InsumoPdfController::class)->name('insumos.pdf'); // antes del resource
Route::resource('insumos', InsumoController::class);
