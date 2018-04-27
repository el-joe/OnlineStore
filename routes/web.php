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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});


Route::get('/','ProductController@index')->name('index');

Route::get('add-to-cart/{id}' , 'ProductController@getAddToCart')->name('product.addToCard')->middleware('auth');

Route::get('shopping-cart','ProductController@getCart')->name('product.shoppingCart')->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/checkout','CheckoutController@index')->name('checkout.index')->middleware('auth');
Route::post('/checkout','CheckoutController@store')->name('checkout.store');

Route::get('reduce/{id}','ProductController@getReduceByOne')->name('product.reduceByOne');

Route::get('remove/{id}','ProductController@getRemoveItems')->name('product.removeItem');

Route::get('add-products','ProductController@addProducts')->name('addProducts');
Route::post('add-products','ProductController@storeProducts')->name('storeProducts');


Route::get('search','ProductController@search')->name('product.search');


