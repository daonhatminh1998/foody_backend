<?php
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProductDetailController;

use App\Http\Controllers\UsersController;
use App\Http\Controllers\MembersController;

use App\Http\Controllers\CartsController;
use App\Http\Controllers\CartDetailController;

use App\Http\Controllers\CustomersController;
use App\Http\Controllers\AddressController;

use App\Http\Controllers\OrderMemController;
use App\Http\Controllers\OrderMemDetailController;

use App\Http\Controllers\OrderCusController;
use App\Http\Controllers\OrderCusDetailController;

use Illuminate\Support\Facades\Route;

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

Route::post('login',[UsersController::class,'login']);
Route::post('register',[UsersController::class,'create']);

Route::get('products/{id?}',[ProductsController::class,'index']);

Route::get('productDetail/get_paging',[ProductDetailController::class,'getPaging']);
Route::get('productDetail/{id?}',[ProductDetailController::class,'index']);
Route::get('productDetail/get_image_url/{id}',[ProductDetailController::class,'getImageUrl']);
Route::get('productDetail/get_image/{id}',[ProductDetailController::class,'getImage']);
Route::get('productDetail/get_image_base64/{id}',[ProductDetailController::class,'getImageBase64']);

Route::get('carts/{id?}',[CartsController::class,'index']);
Route::get('cartDetail/{id?}',[CartDetailController::class,'index']);
Route::post('cartDetail',[CartDetailController::class,'create']);

Route::post('customers',[CustomersController::class,'create']);

Route::get('orderMem/{id?}',[OrderMemController::class,'index']);
Route::post('orderMem',[OrderMemController::class,'create']);
Route::put('orderMem/{id}',[OrderMemController::class,'update']);
Route::delete('orderMem/{id}',[OrderMemController::class,'delete']);

Route::get('orderMemDetail/{id?}',[OrderMemDetailController::class,'index']);

Route::post('orderCus',[OrderCusController::class,'create']);
Route::put('orderCus/{id}',[OrderCusController::class,'update']);
Route::delete('orderCus/{id}',[OrderCusController::class,'delete']);

Route::get('orderCusDetail/{id?}',[OrderCusDetailController::class,'index']);

Route::group(['middleware' => 'auth:api'], function() {
    Route::post('changePassword',[UsersController::class,'changePassword']);
    Route::post('changeInfor',[UsersController::class,'changeInfor']);

    Route::post('productDetail',[ProductDetailController::class,'create']);
    Route::put('productDetail/{id}',[ProductDetailController::class,'update']);
    Route::delete('productDetail/{id}',[ProductDetailController::class,'delete']);

    Route::post('products',[ProductsController::class,'create']);
    Route::put('products/{id}',[ProductsController::class,'update']);
    Route::delete('products/{id}',[ProductsController::class,'delete']);

    Route::get('customers/{id?}',[CustomersController::class,'index']);
    Route::get('address/{id?}',[AddressController::class,'index']);
    Route::put('customers/{id}',[CustomersController::class,'update']);
    Route::delete('customers/{id}',[CustomersController::class,'delete']);

    Route::get('orderCus/get_paging',[OrderCusController::class,'getPaging']);
    Route::get('orderCus/{id?}',[OrderCusController::class,'index']);
});
