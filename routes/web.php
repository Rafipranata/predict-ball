<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\HighlightController::class, 'index'])->name('home');
Route::get('/highlights', [App\Http\Controllers\HighlightController::class, 'index'])->name('highlights');

