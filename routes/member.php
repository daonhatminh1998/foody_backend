<?php
use App\Http\Controllers\MembersController;
use App\Http\Controllers\CartsController;
use App\Http\Controllers\CartDetailController;
use App\Http\Controllers\ReceiverController;

use App\Http\Controllers\OrderMemController;
use App\Http\Controllers\OrderMemDetailController;

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

Route::get('login', function(){
    $response = [
        'status' => 'errorCode',
        'message' => 'Incorrect headers supplied'
    ];
    return response()->json($response, 401);
})->name('login');

Route::get('register', function(){
    $response = [
        'status' => 'errorCode',
        'message' => 'Incorrect headers supplied'
    ];
    return response()->json($response, 401);
})->name('register');

Route::get('changePassword', function(){
    $response = [
        'status' => 'errorCode',
        'message' => 'Incorrect headers supplied'
    ];
    return response()->json($response, 401);
})->name('changePassword');

Route::get('changeInfor', function(){
    $response = [
        'status' => 'errorCode',
        'message' => 'Incorrect headers supplied'
    ];
    return response()->json($response, 401);
})->name('changeInfor');

Route::post('login',[MembersController::class,'login']);
Route::post('register',[MembersController::class,'create']);

//------------------------------------------------------------------------------------------------------------------------------------
Route::group(['middleware' => 'auth:member'], function () {
    Route::post('changePassword',[MembersController::class,'changePassword']);
    Route::post('changeInfor',[MembersController::class,'changeInfor']);

    Route::get('carts/{id?}',[CartsController::class,'index']);
    Route::put('updateCart',[CartsController::class,'updateCart']);
    Route::post('addQuantity',[CartsController::class,'addQuantity']);
    Route::post('deleteItem',[CartsController::class,'deleteItem']);
    Route::delete('deleteAll',[CartsController::class,'deleteAll']);

    Route::get('cartDetail/{id?}',[CartDetailController::class,'index']);
    Route::post('cartDetail',[CartDetailController::class,'create']);
    Route::put('cartDetail/{id?}',[CartDetailController::class,'update']);
    
    Route::get('receiver/{id?}',[ReceiverController::class,'index']);
    Route::post('default',[ReceiverController::class,'default']);
    Route::post('chosen',[ReceiverController::class,'chosen']);
    Route::post('reset',[ReceiverController::class,'reset']);
    Route::post('newReceiver',[ReceiverController::class,'create']);
    Route::put('updateReceiver/{id}',[ReceiverController::class,'update']);
    Route::delete('deleteReceiver/{id}',[ReceiverController::class,'delete']);

    Route::get('orderMem/get_paging',[OrderMemController::class,'getPaging']);
    Route::get('orderMem/{id?}',[OrderMemController::class,'index']);
    Route::post('orderMem',[OrderMemController::class,'order']);

    
});