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

    Route::get('nfts/trending', "NFTController@trending");
    Route::get('nfts/trending/{id}', "NFTController@trendingId");
    Route::get('collections/top', "CollectionController@top");
    Route::get('users/{id}', "UserController@show");
    
    Route::middleware('auth:api')->group(function () {
        // our routes to be protected will go in here
        Route::post('/logout', 'Auth\ApiAuthController@logout')->name('logout.api');
        Route::post('/password/change', 'Auth\ChangePasswordController@change');

        // Post
        Route::get('posts', "PostController@index"); // List Posts
        Route::post('posts', "PostController@store"); // Create Post
        Route::get('posts/{id}', "PostController@show"); // Detail of Post
        Route::put('posts/{id}', "PostController@update"); // Update Post
        Route::delete('posts/{id}', "PostController@destroy"); // Delete Post

        // Topic
        // Route::get('topics', "TopicController@index"); // List topics
        Route::post('topics', "TopicController@store"); // Create Topic
        // Route::get('topics/{id}', "TopicController@show"); // Detail of Topic
        Route::put('topics/{id}', "TopicController@update"); // Update Topic
        Route::delete('topics/{id}', "TopicController@destroy"); // Delete Topic

        // Crypto
        // Route::get('cryptos', "CryptoController@index"); // List cryptos
        Route::post('cryptos', "CryptoController@store"); // Create Crypto
        // Route::get('cryptos/{id}', "CryptoController@show"); // Detail of Crypto
        Route::put('cryptos/{id}', "CryptoController@update"); // Update Crypto
        Route::delete('cryptos/{id}', "CryptoController@destroy"); // Delete Crypto

        // Transaction
        Route::get('transactions', "TransactionController@index"); // List transactions
        Route::post('transactions', "TransactionController@store"); // Create transaction
        Route::get('transactions/{id}', "TransactionController@show"); // Detail of transaction
        Route::put('transactions/{id}', "TransactionController@update"); // Update transaction
        Route::delete('transactions/{id}', "TransactionController@destroy"); // Delete transaction

        // NFT
        // Route::get('nfts', "NFTController@index"); // List nfts
        Route::post('nfts', "NFTController@store"); // Create nft
        // Route::get('nfts/{id}', "NFTController@show"); // Detail of nft
        Route::put('nfts/{id}', "NFTController@update"); // Update nft
        Route::delete('nfts/{id}', "NFTController@destroy"); // Delete nft

        // Collection
        // Route::get('collections', "CollectionController@index"); // List collections
        Route::post('collections', "CollectionController@store"); // Create collection
        // Route::get('collections/{id}', "CollectionController@show"); // Detail of collection
        Route::put('collections/{id}', "CollectionController@update"); // Update collection
        Route::delete('collections/{id}', "CollectionController@destroy"); // Delete collection

        // Account Blance
        Route::get('account_balances', "AccountBalanceController@index"); // List account_blances
        Route::post('account_balances', "AccountBalanceController@store"); // Create account_blance
        Route::get('account_balances/{id}', "AccountBalanceController@show"); // Detail of account_blance
        Route::put('account_balances/{id}', "AccountBalanceController@update"); // Update account_blance
        Route::delete('account_balances/{id}', "AccountBalanceController@destroy"); // Delete account_blance

        // Notify
        Route::get('notifies', "NotifyController@index"); // List notifies
        Route::post('notifies', "NotifyController@store"); // Create notifies
        Route::get('notifies/{id}', "NotifyController@show"); // Detail of notifies
        Route::put('notifies/{id}', "NotifyController@update"); // Update notifies
        Route::delete('notifies/{id}', "NotifyController@destroy"); // Delete notifies

        Route::get('/admin', function (Request $request) {
            return response()->json([
                'message' => "you are admin."
            ],200);
        })->middleware('api.admin');

        Route::get('/super_admin', function (Request $request) {
            return response()->json([
                'message' => "you are super admin."
            ],200);
        })->middleware('api.superAdmin');
    });
});

Route::get('nfts', "NFTController@index");
Route::get('nfts/{id}', "NFTController@show");
// Route::get('nfts/trending', "NFTController@trending");
Route::get('cryptos', "CryptoController@index");
Route::get('cryptos/{id}', "CryptoController@show");

Route::get('topics', "TopicController@index");
Route::get('topics/{id}', "TopicController@show");

Route::get('collections', "CollectionController@index");
Route::get('collections/{id}', "CollectionController@show");

// Route::get('topics', "TopicController@index");
// Route::get('transactions', "TransactionController@index");
// Route::get('topics', "TopicController@index");
// Route::get('nfts', "NFTController@index");
