<?php


Route::get('/', 'BlogController@home')->name('home');
Route::resource('blogs', 'BlogController');