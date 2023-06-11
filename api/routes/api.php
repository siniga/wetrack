<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


// clear route cache
Route::get('/clear-route-cache', function () {
    Artisan::call('route:cache');
    return 'Routes cache has clear successfully !';
});

//clear config cache
Route::get('/clear-config-cache', function () {
    Artisan::call('config:cache');
    return 'Config cache has clear successfully !';
});

Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');

Route::group(['middleware' => ['auth:sanctum']], function(){

//teams routes
Route::get('/teams/business/{businessId}', 'TeamController@getTeamsByBusinessId');

//users routes
Route::get('/users/team/{teamId}/role/{role}', 'UserController@getUsersByteamId');


//orders routes
Route::get('/orders', 'OrderController@index');
Route::get('/orders/status/{status}/business/{businessId}', 'OrderController@getByBusinessId');
Route::post('/orders', 'OrderController@store');
Route::get('/orders/{order}', 'OrderController@show');
Route::put('/orders/{order}', 'OrderController@update');
Route::delete('/orders/{order}', 'OrderController@destroy');

//categories routes
Route::get('/categories/business/{businessId}', 'CategoryController@getCategoriesByBusinessId');

//products routes
Route::get('/products/category/{categoryId}', 'ProductController@getProductsByCategoryId');

//customers routes
Route::get('/customers/business/{businessId}', 'CustomerController@getCustomersByBusinessId');

});