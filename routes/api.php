<?php

use Illuminate\Http\Request;
use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});




Route::group(['namespace' => 'Api', 'prefix' => env('API_PREFIX')], function () {
    Route::post('/login', 'AuthController@login')->name('login');
    Route::post('/loginout', 'AuthController@logout')->name('loginout');
    // Route::post('/logout', 'AuthenticationController@logout')->middleware('auth:api');
    // Route::post('/register', 'RegisterController@register');
    // Route::post('/forgot', 'ForgotPasswordController@forgot');
    // Route::post('/reset', 'ForgotPasswordController@reset');
});