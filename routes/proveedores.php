<?php

use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ProveedorPdfController;
use Illuminate\Support\Facades\Route;

// Se incluye desde routes/web.php dentro del grupo con middleware 'auth'.
Route::get('proveedores/pdf', ProveedorPdfController::class)->name('proveedores.pdf'); // antes del resource
Route::resource('proveedores', ProveedorController::class)->parameters(['proveedores' => 'proveedor']);