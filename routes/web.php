<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Pages'], function () {
    Route::get('/', 'Home')
        ->name('pages.home');
});
