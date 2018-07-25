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

Route::view('login', 'auth.login')->name('login');
Route::post('login', 'Auth\LoginController@login');

Route::group(['middleware' => 'auth'], function() {
    Route::view('/', 'dashboard');
    Route::post('logout', 'Auth\LoginController@logout');

    Route::get('users', 'UsersController@index');
    Route::get('users/{user}', 'UsersController@show');
    Route::post('users', 'UsersController@store');
    Route::post('users/{user}', 'UsersController@update');
    Route::delete('users/{user}', 'UsersController@delete');

    Route::view('reset-password', 'auth.reset-password');
    Route::post('reset-password', 'UserPasswordController@update');

    Route::post('blog/posts', 'Blog\PostsController@store');
    Route::post('blog/posts/{post}', 'Blog\PostsController@update');
});


