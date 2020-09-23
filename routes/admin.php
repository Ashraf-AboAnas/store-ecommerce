<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
    ], function () {

        Route::group(['namespace' => 'Dashboard', 'prefix' => 'admin', 'middleware' => 'auth:admin'], function () {
            Route::get('/', 'DashboardController@index')->name('admin.dashboard');

            Route::get('logout','LoginController@logout')->name('admin.logout');

            Route::group(['prefix' => 'settings'], function () {
                Route::get('shipping-methods/{type}', 'SettingsController@editShippingMethods')->name('edit.shipping.methods');
                Route::put('shipping-methods/{id}', 'SettingsController@updateShippingMethods')->name('update.shipping.methods');

            });
            Route::group(['prefix' => 'profiles'], function () {
                Route::get('edit', 'ProfileController@editprofile')->name('edit.profiles');
                Route::put('update', 'ProfileController@updataprofile')->name('update.profile');

            });
            /***************************  Catrgory Route **************************** */
            Route::resource('maincategories','MaincategoriesController',['as'=>'admin']);

         ################################## categories routes ######################################
        // Route::group(['prefix' => 'main_categories'], function () {
        //     Route::get('/','MainCategoriesController@index') -> name('admin.maincategories');
        //     Route::get('create','MainCategoriesController@create') -> name('admin.maincategories.create');
        //     Route::post('store','MainCategoriesController@store') -> name('admin.maincategories.store');
        //     Route::get('edit/{id}','MainCategoriesController@edit') -> name('admin.maincategories.edit');
        //     Route::post('update/{id}','MainCategoriesController@update') -> name('admin.maincategories.update');
        //     Route::get('delete/{id}','MainCategoriesController@destroy') -> name('admin.maincategories.delete');
        // });
            /***************************End Catrgory Route************************* */
    /***************************  subCategories Route **************************** */
    Route::resource('subcategories','SubCategoriesController',['as'=>'admin']);

    ################################## subcategories routes ######################################

     /***************************  BrandsController Route **************************** */
     Route::resource('brands','BrandsController',['as'=>'admin']);

     ################################## BrandsController routes ######################################
        /***************************  TagsController Route **************************** */
     Route::resource('tags','TagsController',['as'=>'admin']);

     ################################## TagsController routes ######################################
        });

        Route::group(['namespace' => 'Dashboard', 'prefix' => 'admin', 'middleware' => 'guest:admin'], function () {
            Route::get('login', 'LoginController@login')->name('admin.login');
            Route::post('login', 'LoginController@postlogin')->name('admin.postlogin');

        });

    }); //end group translation
