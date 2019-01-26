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

Route::get(
    '/',
    '\App\Http\Controllers\UsersController@showNewUserPage'
)->name('new-user');


Route::get(
    '/{id}',
    '\App\Http\Controllers\UsersController@showUserPage'
)
->where('id', '[0-9]+')
->name('show-user');

Route::post(
    '/',
    '\App\Http\Controllers\UsersController@saveUser'
)->name('save-user');
