<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('me', 'App\Http\Controllers\User\MeController@getMe');

Route::group(['middleware' => ['auth:api']], function(){
    Route::post('logout', 'App\Http\Controllers\Auth\LoginController@logout');
    //Route::put('settings/profile', 'App\Http\Controllers\User\SettingsController@updateProfile');
    //Route::put('settings/password', 'App\Http\Controllers\User\SettingsController@updatePassword');

    Route::patch('posts', 'App\Http\Controllers\PostController@index');
    Route::patch('posts/{id}', 'App\Http\Controllers\PostController@findPost');
    Route::post('posts/create', 'App\Http\Controllers\PostController@create');
    Route::put('posts/update/{id}', 'App\Http\Controllers\PostController@update');
    Route::delete('posts/delete/{id}', 'App\Http\Controllers\PostController@destroy');

    Route::patch('users', 'App\Http\Controllers\User\UserController@index');
    Route::patch('users/{id}', 'App\Http\Controllers\User\UserController@findUser');
    Route::post('users/create', 'App\Http\Controllers\User\UserController@create');
    Route::put('users/update/{id}', 'App\Http\Controllers\User\UserController@update');
    Route::delete('users/delete/{id}', 'App\Http\Controllers\User\UserController@delete');

    Route::patch('statistics', 'App\Http\Controllers\StatisticController@index');

    Route::post('comments/{id}', 'App\Http\Controllers\PostController@storeComment');
    Route::delete('comments/delete/{id}/{comment_id}', 'App\Http\Controllers\PostController@deleteComment');
});
Route::group(['middleware' => ['guest:api']], function(){
    Route::post('register', 'App\Http\Controllers\Auth\RegisterController@register');
    Route::post('verification/verify/{user}', 'App\Http\Controllers\Auth\VerificationController@verify')->name('verification.verify');
    Route::post('verification/resend', 'App\Http\Controllers\Auth\VerificationController@resend');
    Route::post('login', 'App\Http\Controllers\Auth\LoginController@login');
    Route::post('password/email', 'App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'App\Http\Controllers\Auth\ResetPasswordController@reset')->name('password.reset'); 
});