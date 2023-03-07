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
    Route::post('register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
    Route::post('send-sms', [\App\Http\Controllers\Api\AuthController::class, 'send']);
    Route::post('verify', [\App\Http\Controllers\Api\AuthController::class, 'verify']);

});

Route::middleware(['auth:sanctum'])->group(function (){

    Route::prefix('main')->group(function (){
        Route::get('get-banners', [\App\Http\Controllers\Api\MainPageController::class, 'getBanners'] );
        Route::get('get-categories', [\App\Http\Controllers\Api\MainPageController::class, 'getCategories'] );
        Route::get('get-tags', [\App\Http\Controllers\Api\MainPageController::class, 'getTags']);
    });

    Route::prefix('institution')->group(function (){
        Route::get('detail/{institution_id}', [\App\Http\Controllers\Api\InstitutionController::class, 'detail']);
        Route::get('get-list', [\App\Http\Controllers\Api\InstitutionController::class, 'getList']);
        Route::get('my/get-list', [\App\Http\Controllers\Api\InstitutionController::class, 'getMyInstitutions']);
        Route::get('get-cards/{institution_id}', [\App\Http\Controllers\Api\InstitutionController::class, 'getCards']);
        Route::post('rating/past', [\App\Http\Controllers\Api\RatingController::class, 'past']);

        Route::post('favourite/sub/{institution_id}', [\App\Http\Controllers\Api\FavouriteController::class, 'subscribe']);
        Route::post('favourite/unsub/{institution_id}', [\App\Http\Controllers\Api\FavouriteController::class, 'unsubscribe']);
        Route::get('favourite/get-list', [\App\Http\Controllers\Api\FavouriteController::class, 'getList']);

    });


    Route::prefix('user')->group(function (){
        Route::get('get-profile', [\App\Http\Controllers\Api\UserController::class, 'getProfile']);
        Route::post('update', [\App\Http\Controllers\Api\UserController::class, 'update']);
        Route::get('get-city', [\App\Http\Controllers\Api\UserController::class, 'getCity']);


        Route::get('notification/get-list', [\App\Http\Controllers\Api\NotificationController::class, 'getList']);
        Route::get('notification/unread', [\App\Http\Controllers\Api\NotificationController::class, 'unread']);
        Route::post('notification/read-all', [\App\Http\Controllers\Api\NotificationController::class, 'readAll']);
    });

    Route::post('partner/qr/scan', [\App\Http\Controllers\Api\QrController::class, 'attendance']);
});
