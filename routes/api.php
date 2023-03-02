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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('unauthorized', [\App\Http\Controllers\Api\AuthController::class, 'unauthorized'])->name('unauthorized');


Route::get('get-cities', [\App\Http\Controllers\Api\MainPageController::class, 'getCities']);
Route::prefix('auth')->group(function (){
    Route::post('login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

});

Route::middleware(['auth:sanctum'])->group(function (){

    Route::prefix('main')->group(function (){
        Route::get('get-banners', [\App\Http\Controllers\Api\MainPageController::class, 'getBanners'] );
        Route::get('get-categories', [\App\Http\Controllers\Api\MainPageController::class, 'getCategories'] );
        Route::get('get-tags', [\App\Http\Controllers\Api\MainPageController::class, 'getTags']);
    });


    Route::get('institution/detail/{institution_id}', [\App\Http\Controllers\Api\InstitutionController::class, 'detail']);
    Route::get('institution/get-list', [\App\Http\Controllers\Api\InstitutionController::class, 'getList']);

    Route::prefix('user')->group(function (){
        Route::get('get-profile', [\App\Http\Controllers\Api\UserController::class, 'getProfile']);
        Route::post('update', [\App\Http\Controllers\Api\UserController::class, 'update']);
    });


});
