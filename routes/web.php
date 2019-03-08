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


Route::view('login', 'auth.login')->name('login');
Route::post('login', 'Auth\LoginController@login');


Route::group(['middleware' => 'auth'], function() {
    Route::get('/', 'DashboardController@show');
    Route::post('logout', 'Auth\LoginController@logout');

    Route::get('users', 'UsersController@index');
    Route::get('users/{user}', 'UsersController@show');
    Route::post('users', 'UsersController@store');
    Route::post('users/{user}', 'UsersController@update');
    Route::delete('users/{user}', 'UsersController@delete');

    Route::view('reset-password', 'auth.reset-password');
    Route::post('reset-password', 'UserPasswordController@update');

    Route::get('blog', 'Blog\PostsController@index');
    Route::get('blog/posts/{post}/edit', 'Blog\PostsController@edit');
    Route::get('blog/posts/{post}', 'Blog\PostsController@show');
    Route::post('blog/posts', 'Blog\PostsController@store');
    Route::post('blog/posts/{post}', 'Blog\PostsController@update');

    Route::post('blog/posts/{post}/title-image', 'Blog\PostTitleImageController@store');

    Route::post('blog/posts/{post}/images', 'Blog\PostImagesController@store');

    Route::get('instagram-feed-status', 'InstagramFeedStatusController@show');

    Route::redirect('instagram-auth-success', '/');
});

Route::group(['middleware' => 'auth', 'namespace' => 'Service', 'prefix' => 'api'], function() {
   Route::get('blog/posts', 'PostsController@index');
});


