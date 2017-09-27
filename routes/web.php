<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Route::get('/', 'WebController@dashboard');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/verify-email/{token}', 'UserController@verifyUser');
Route::get('/reset-password/{token}', 'UserController@resetPassword');
