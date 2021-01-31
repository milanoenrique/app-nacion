<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StarshipController;

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

Route::get('/', function (Request $request) {
  return "Swapi Inventory V 1.0";
});

Route::post('/add',[StarshipController::class,'addToInventory']);

Route::group(['prefix'=>'inventory'],function(){
    Route::get('/{type}/search',[StarshipController::class, 'get_count_starships']);
    Route::post('/{type}/modify-quantity',[StarshipController::class,'addToInventory']);

});
