<?php
use Illuminate\Support\Facades\Route;


//login
Route::post('/login','AuthController@loginWithPhoneNum');

Route::group(['middleware' => ['auth:sanctum']], function(){

//reports
Route::get('reports/user','mobile\ReportController@getReport');

//products
Route::get('products/business/{bid}','ProductController@getProductsByBusinessId');

//categories
Route::get( 'categories/business/{id}', 'CategoryController@getBusinessCategories' );

//skus
Route::get( 'skus/business/{bid}/product/{pid}', 'SkuController@getBusinessProductSku' );

//visitation
Route::post('agent/customer/stats', 'AgentController@markVisitation');

 //customers
 Route::get('customers/user','CustomerController@getCustomerByUserid');

 //regions
 Route::get('regions-districts','RegionController@getRegionDistricts');

 //register user as customer
 Route::post('user','UserController@storeUserCustomer');

    
});