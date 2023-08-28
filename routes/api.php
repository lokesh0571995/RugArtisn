<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\FinanceController;
use App\Http\Controllers\Api\AdminController;
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

//register and login route
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [RegisterController::class, 'login']);

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/logout', [RegisterController::class, 'logout']);

});


// user protected routes
Route::group(['middleware' => ['auth:api','users','throttle:60,1'], 'prefix' => 'user'], function () {
  
    Route::get('/list', [FinanceController::class, 'index']);
    Route::post('/store', [FinanceController::class, 'store']);
    Route::post('/update/{id}', [FinanceController::class, 'update']);
    Route::get('/delete/{id}', [FinanceController::class, 'destroy']);
});

// admin protected routes
Route::group(['middleware' => ['auth:api'], 'prefix' => 'admin'], function () {
   
    Route::get('all-transaction-list', [AdminController::class, 'allTransactionList']);
    Route::get('/delete', [AdminController::class, 'destroy']);
    Route::get('/user-all-transaction-delete', [AdminController::class, 'userTransactionDestroy']);
});   


Route::fallback(function(){
    return response()->json([
        'message' => 'Page Not Found.'], 404);
});
