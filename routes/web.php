<?php

use App\Http\Controllers\WeatherController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WeatherController::class, 'index']);

Route::get('/search-city', [WeatherController::class, 'searchCity'])->name('search.city');
