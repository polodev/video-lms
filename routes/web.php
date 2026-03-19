<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('series.index'));

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');
