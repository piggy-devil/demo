<?php

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

// Route::get('{any}', 'AppController@index')
//     ->where('any', '.*')
//     ->middleware('auth')
//     ->name('home');


Route::resource('channels', 'ChannelController');
