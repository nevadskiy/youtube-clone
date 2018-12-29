<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::view('/', 'welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/channel/{channel}', 'ChannelController@show')->name('channels.show');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/channel/{channel}/edit', 'ChannelSettingsController@edit')->name('channels.edit');
    Route::put('/channel/{channel}', 'ChannelSettingsController@update')->name('channels.update');
});