<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');

Route::prefix('kyarcom')->group(function () {
    Route::get('/', [\App\Http\Controllers\ComputeController::class, 'index'])->name('kyarcom.kyarcom-data-list');
    Route::post('/store', [\App\Http\Controllers\ComputeController::class, 'store'])->name('kyarcom.kyarcom-data-store');
    Route::get('/download-template', [\App\Http\Controllers\ComputeController::class, 'downloadTemplate'])->name('kyarcom.download-template-kyarcom');
    Route::post('/import-tractors', [\App\Http\Controllers\ComputeController::class, 'importTractroKyarcom'])->name('kyarcom.import-kyarcom');
});
