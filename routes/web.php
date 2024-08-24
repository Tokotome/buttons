<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ButtonController;

Route::get('/', [ButtonController::class, 'index'])->name('buttons.index');
Route::get('/buttons/edit/{id}', [ButtonController::class, 'edit'])->name('buttons.edit');
Route::put('/buttons/{id}', [ButtonController::class, 'update'])->name('buttons.update');
Route::delete('/buttons/{id}', [ButtonController::class, 'destroy'])->name('buttons.destroy');



