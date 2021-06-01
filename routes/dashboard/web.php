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

        //product Routes
        Route::resource('products','ProductController')->except('show');

        //category Routes
        Route::resource('categories','CategoryController')->except('show');

        //client Routes
        Route::resource('clients','ClientController')->except('show');
        Route::resource('clients.orders','Client\OrderController')->except('show');

        //order Routes
        Route::resource('orders', 'OrderController');
        Route::get('/orders/{order}/product','OrderController@products')->name('orders.products');

    });

});

