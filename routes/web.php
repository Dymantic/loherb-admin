<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('login', 'Auth\LoginController@login');

Route::group(['middleware' => 'auth'], function() {
    Route::post('logout', 'Auth\LoginController@logout');
    Route::post('users', 'UsersController@store');
    Route::post('users/{user}', 'UsersController@update');
    Route::delete('users/{user}', 'UsersController@delete');

    Route::post('reset-password', 'UserPasswordController@update');

    Route::post('blog/posts', 'Blog\PostsController@store');
    Route::post('blog/posts/{post}', 'Blog\PostsController@update');
});


