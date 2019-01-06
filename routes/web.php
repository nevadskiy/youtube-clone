<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::view('/', 'welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/channel/{channel}', 'ChannelController@show')->name('channels.show');

Route::get('/videos/{video}', 'VideoController@show')->name('videos.show');

Route::post('/videos/{video}/views', 'VideoViewController@store');

Route::get('/videos/{video}/votes', 'VideoVoteController@show')->name('votes.show');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/upload', 'VideoUploadController@index')->name('videos-upload.index');
    Route::post('/upload', 'VideoUploadController@store')->name('videos-upload.store');

    Route::get('/videos', 'VideoController@index')->name('videos.index');
    Route::post('/videos', 'VideoController@store')->name('videos.store');
    Route::get('/videos/{video}/edit', 'VideoController@edit')->name('videos.edit');
    Route::put('/videos/{video}', 'VideoController@update')->name('videos.update');
    Route::delete('/videos/{video}', 'VideoController@destroy')->name('videos.destroy');

    Route::get('/channel/{channel}/edit', 'ChannelSettingsController@edit')->name('channels.edit');
    Route::put('/channel/{channel}', 'ChannelSettingsController@update')->name('channels.update');

    Route::post('/videos/{video}/votes', 'VideoVoteController@store')->name('votes.store');
    Route::delete('/videos/{video}/votes', 'VideoVoteController@destroy')->name('votes.destroy');
});