<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\CityController;
use App\Http\Controllers\api\v1\CountryController;

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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('/', function(){
    return 'hello';
});

Route::controller(CityController::class)->group(function(){
    Route::get('/cities', 'index');
    Route::get('/city/{id}', 'show');
    Route::post('/city', 'store');
    Route::put('/city/{id}', 'update');
    Route::delete('/city/{id}', 'destroy');
});

Route::controller(CountryController::class)->group(function(){
    Route::get('/countries', 'index');
    Route::get('/country/{id}', 'show');
    Route::post('/country', 'store');
    Route::put('/country/{id}', 'update');
    Route::delete('/country/{id}', 'destroy');
});