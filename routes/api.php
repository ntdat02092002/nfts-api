<?php

use Illuminate\Http\Request;
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

Route::group(['middleware' => ['cors', 'json.response']], function () {
    // public routes
    Route::post('/login', 'Auth\ApiAuthController@login')->name('login.api');
    Route::post('/register','Auth\ApiAuthController@register')->name('register.api');

    Route::post('/password/forgot', 'Auth\ResetPasswordController@forgot');
    Route::get('/password/find/{token}', 'Auth\ResetPasswordController@find');
    Route::post('/password/reset', 'Auth\ResetPasswordController@reset');
    
    Route::middleware('auth:api')->group(function () {
        // our routes to be protected will go in here
        Route::post('/logout', 'Auth\ApiAuthController@logout')->name('logout.api');

        Route::get('posts', "PostController@index"); // List Posts
        Route::post('posts', "PostController@store"); // Create Post
        Route::get('posts/{id}', "PostController@show"); // Detail of Post
        Route::put('posts/{id}', "PostController@update"); // Update Post
        Route::delete('posts/{id}', "PostController@destroy"); // Delete Post
    });
});

