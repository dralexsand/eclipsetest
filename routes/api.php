<?php

use App\Http\Controllers\Api\v1\TagsController;
use App\Http\Controllers\Api\v1\ArticlesController;
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

Route::group(['middleware' => ['throttle:20,1']], function () {
    Route::apiResource('articles', ArticlesController::class);

    Route::get('/tags', [TagsController::class, 'index']);
    Route::get('/tags/{id}', [TagsController::class, 'show']);
    Route::put('/tags/{id}', [TagsController::class, 'update']);
    Route::delete('/tags/{id}', [TagsController::class, 'destroy']);
    //Route::apiResource('tags', TagsController::class);
});



