<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath',]
    ], function(){
    Route::middleware(['auth'])->group(function (){

        Route::get('/index','WelcomeController@index')->name('dashboard.index');

        //user Routes
        Route::resource('users','UserController')->except('show');

        //category Routes
        Route::resource('categories','CategoryController')->except('show');

    });

});

