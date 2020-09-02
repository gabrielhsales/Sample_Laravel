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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('register', 'AuthController@register');

Route::post('auth/login', ['uses' => 'AuthController@login', 'as' => 'login']);

// Route::get('products', ['middleware' => 'auth.role:admin,user', 'uses' => 'ProductController@index', 'as' => 'products']);

Route::get('users/profile', ['middleware' => 'auth.role:visitante', 'uses' => 'UsersController@profile']);
// Route::get('users/block', ['middleware' => 'auth.role:admin', 'uses' => 'UsersController@blockUser', 'as' => 'users.block']);


Route::group([

    'middleware' => 'auth.role:admin, tecnico'

], function ($router) {

    Route::get('users/block', ['uses' => 'UsersController@blockUser', 'as' => 'users.block']);
});
