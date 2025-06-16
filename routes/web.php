<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;



Route::get('/index', [DocumentController::class , 'index'])->name('dashboard');

Route::get('/documents/search', [DocumentController::class, 'searchView'])
    ->name('documents.search');

Route::get('/documents/searchHandle', [DocumentController::class, 'search'])
    ->name('documents.searchHandle');

Route::resource('documents', DocumentController::class);
