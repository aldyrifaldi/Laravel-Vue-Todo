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

Route::middleware('jwt.verify')->get('/user', function (Request $request) {
    return $request->user();
});


$controller = 'App\Http\Controllers';

Route::group(['prefix' => 'auth'], function () use ($controller) {
    Route::post('login',$controller.'\Api\AuthController@login');
    Route::post('register',$controller.'\Api\AuthController@register');
    Route::post('logout',$controller.'\Api\AuthController@logout')->middleware('jwt.verify');
});

Route::group(['middleware' => 'jwt.verify'], function () use ($controller){
    Route::resource('todo', $controller.'\Api\TodoController');
    Route::put('todo/check-uncheck/{todo}', $controller.'\Api\TodoController@checkUncheck');
});
