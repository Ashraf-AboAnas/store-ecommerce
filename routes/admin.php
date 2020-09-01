<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['namespace' => 'Dashboard','prefix' =>'admin','middleware' => 'auth:admin'], function () {
    Route::get('/','DashboardController@index')->name('admin.dashboard');

});

Route::group(['namespace' => 'Dashboard','prefix' =>'admin','middleware' => 'guest:admin'], function () {
    Route::get('login','LoginController@login')->name('admin.login');
    Route::post('login','LoginController@postlogin')->name('admin.postlogin');


 });
