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

//auth routes
Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');

Route::group(['middleware' => ['auth:sanctum']], function(){

//reports
Route::get('/reports/business/{businessId}','ReportController@getReports');
     
//teams routes
Route::get('/regions', 'RegionController@index');

//visits
Route::get('/visits/business/{businessId}','CustomerVisitController@getVisitsByBusinessId');
Route::post('/visits','CustomerVisitController@store');

//teams routes
Route::get('/teams/business/{businessId}', 'TeamController@getTeamsByBusinessId');
Route::post('/teams', 'TeamController@store');
Route::post('/teams/assign/supervisor', 'TeamController@assignSupervisor');

//users routes
Route::get('/users/business/{businessId}', 'UserController@index');
Route::get('/users/business/{businessId}/region/{regionId}', 'UserController@getUsersByRegion');
Route::get('/users/{id}', 'UserController@show');
Route::post('/users', 'UserController@store');
Route::put('/users/{user}', 'UserController@update');
Route::post('/users/update-password', 'UserController@updatePassword');
Route::get('/users/team/{teamId}/role/{role}', 'UserController@getUsersByteamId');
Route::get('/users/role/{role}/business/{businessId}', 'UserController@getUsersByRoleId');

//orders routes
Route::get('/orders', 'OrderController@index');
Route::get('/orders/export/data', 'OrderController@exportData');
Route::get('/orders/business/{businessId}', 'OrderController@getOrderByBusinessId');
Route::get('/orders/markers/business/{businessId}/flag/{flag}/user/{userId}','OrderController@getOrderMarkersByBusinessId');
Route::get('/orders/user/{date}/status/{status}','OrderController@getOrdersByUserid');
Route::post('/orders', 'OrderController@store');
Route::get('/orders/{order}', 'OrderController@show');
Route::put('/orders/{order}', 'OrderController@update');
Route::delete('/orders/{order}', 'OrderController@destroy');


//categories routes
Route::get('/categories/business/{businessId}', 'CategoryController@getCategoriesByBusinessId');
Route::post('/categories', 'CategoryController@store');

//products routes
Route::get('/products/category/{categoryId}', 'ProductController@getProductsByCategoryId');
Route::get('/products/business/{businessId}', 'ProductController@getProductsByBusinessId');
Route::post('/products', 'ProductController@store');

//customers routes
Route::get('/customers/business/{businessId}', 'CustomerController@getCustomersByBusinessId');
Route::post('/customers', 'CustomerController@store');
Route::put('/customers', 'CustomerController@update');
// Route::get('/customers/insert', 'CustomerController@insertCustomers');

//customer types routes
Route::get('/customers/types', 'CustomerTypeController@index');

});