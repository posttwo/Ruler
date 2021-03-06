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
Auth::routes(['register' => false]);
Route::get('/home', 'HomeController@index')->name('home');

//Webhook
Route::group(['middleware' => 'auth', 'prefix' => 'webhook'], function () {
    Route::get('/', 'WebhookController@index');
    Route::get('/{webhook}/rule', 'WebhookController@indexRules');
});
Route::any('/webhook/invoke/{webhook_secret}', 'WebhookController@invoke'); //needs lack of any middleware @TODO except throttling

Route::group(['middleware' => 'auth', 'prefix' => 'quicklink'], function () {
    Route::get('/', 'QuicklinkController@index');
});

Route::get('/q/{quicklink}/{any}', 'QuicklinkController@invoke');