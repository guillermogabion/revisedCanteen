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
Route::post('login','UserController@login');
Route::post('UserRegistration','UserController@UserRegistration');
Route::post('addMeal', 'MealController@addMeal');

Route::post('/logout', 'UserControler@logout')->middleware('auth:api');


Route::middleware('auth:api')->group(function () {
    Route::get('self', 'UserController@self');
    
    // user
    Route::post('saveNew', 'UserController@saveNew');
    Route::post('editUser/{id}', 'UserController@editUser');
    Route::get('users/pagination','UserController@pagination');
    Route::delete('deleteUser/{id}','UserController@deleteUser');

    // meal 
    Route::post('updateMeal/{id}', 'MealController@updateMeal');
    Route::delete('removeMeal', 'MealController@removeMeal');
    Route::get('getAllMeal', 'MealController@getAllMeal');
    // Route::get('searchMeal', 'MealController@searchMeal');
    Route::get('meals/pagination', 'MealController@pagination');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


