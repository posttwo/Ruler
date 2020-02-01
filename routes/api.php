<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth')->get('/conduit', 'API\UtilController@whoami');

//Webhooks
Route::group(['middleware' => 'auth', 'prefix' => 'webhook'], function () {
    Route::get('/', 'API\WebhookController@index');
    Route::post('/', 'API\WebhookController@store');

    Route::get('/{webhook}/invocation', 'API\WebhookController@indexInvocations');

    Route::get('/{webhook}/rule', 'API\WebhookController@indexRules');
    Route::post('/{webhook}/rule', 'API\WebhookController@storeRule');
});