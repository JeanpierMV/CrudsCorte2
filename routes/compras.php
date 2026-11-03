<?php

use App\Http\Controllers\CompraController;
use App\Http\Controllers\CompraPdfController;
use App\Http\Controllers\KardexController;
use App\Http\Controllers\KardexPdfController;
use Illuminate\Support\Facades\Route;

// Se incluye desde routes/web.php dentro del grupo con middleware 'auth'.
Route::get('compras/pdf', CompraPdfController::class)->name('compras.pdf');
Route::resource('compras', CompraController::class)->only(['index', 'create', 'store', 'show']);

Route::get('kardex/pdf', KardexPdfController::class)->name('kardex.pdf');
Route::get('kardex', [KardexController::class, 'index'])->name('kardex.index');
