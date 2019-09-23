<?php

declare(strict_types=1);

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

Route::group(['prefix' => 'v1'], function ($router) {
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('login', 'AuthController@login');

    Route::apiResource('articles', 'ArticleController');
    Route::apiResource('articles.comments', 'CommentController');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::get('me', 'AuthController@me');
    });
});

Route::fallback(function () {
    return response()->json(['message' => 'Not Found'], 404);
});
