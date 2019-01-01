<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::view('/', 'welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/channel/{channel}', 'ChannelController@show')->name('channels.show');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/upload', 'VideoUploadController@index')->name('video-upload.index');
    Route::post('/upload', 'VideoUploadController@store')->name('video-upload.store');

    Route::post('/videos', 'VideoController@store')->name('video.store');
    Route::put('/videos/{video}', 'VideoController@update')->name('video.update');

    Route::get('/channel/{channel}/edit', 'ChannelSettingsController@edit')->name('channels.edit');
    Route::put('/channel/{channel}', 'ChannelSettingsController@update')->name('channels.update');
});