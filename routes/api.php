<?php
namespace App\Http\Controllers;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers'
], function($router){
    // Route::post('login', ['as'=> 'login', 'uses'=> 'AuthController@login']);
    // Route::post('register', ['as'=> 'register', 'uses'=> 'AuthController@register']);
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('profile', 'AuthController@profile');

    Route::get('users', 'UserController@index');
    Route::post('users/store', 'UserController@store');
    Route::get('users/{id}', 'UserController@show');
    Route::get('users/identity/{id}', 'UserController@show_identity_id');
    Route::put('users/{id}', 'UserController@update');
    Route::delete('users/{id}', 'UserController@destroy');
});


Route::apiResource('person', PersonController::class);
Route::apiResource('products', ProductController::class);
Route::apiResource('books', BookController::class);
Route::apiResource('roles', RoleController::class);
//Route::get('books/{$book_id}', 'BookController@show');
