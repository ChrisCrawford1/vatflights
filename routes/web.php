<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Pages'], function () {
    Route::get('/', 'Home')
        ->name('pages.home');
    Route::get('/about', 'About')
        ->name('pages.about');
});

Route::group(['namespace' => 'Search'], function () {
    Route::get('/search', 'Show')
        ->name('search.show');
});

Route::group(['namespace' => 'Airlines', 'prefix' => 'airlines'], function () {
    Route::get('/{airline:uuid}', 'Show')
        ->name('airlines.show');
});

Route::group(['namespace' => 'Callsigns', 'prefix' => 'callsign'], function () {
    Route::get('/{callsign:uuid}', 'Show')
        ->name('callsign.show');
});

Route::group(['namespace' => 'Stats', 'prefix' => 'stats'], function () {
    Route::get('/', 'Show')
        ->name('stats.show');
});
