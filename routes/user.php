<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;


Route::group(['prefix' => 'user','middleware' => 'userMiddleware'],function(){
    Route::get('home',[UserController::class,'userHome'])->name('user#home');
    Route::get('profile',[UserController::class,'profile'])->name('user#profile');
    Route::post('profile',[UserController::class,'profileEdit'])->name('user#profileUpdate');
    Route::get('password',[UserController::class,'passwordPage'])->name('user#password');
    Route::post('password',[UserController::class,'passwordChange'])->name('password#update');
    Route::group(['prefix' => 'product'],function(){
        Route::get('detail/{id}',[UserController::class,'productDetail'])->name('user#productDetail');
        Route::post('comment',[UserController::class,'storeComment'])->name('user#productComment');
        Route::get('commentDelete/{id}',[UserController::class,'deleteComment']);
        Route::post('rating',[UserController::class,'rating'])->name('user#rating');
    });
    Route::get('contact',[UserController::class,'contactPage'])->name('contact#page');
    Route::post('contact',[UserController::class,'storeContact'])->name('contact#store');
    Route::post('addCart',[UserController::class,'addCart'])->name('cart#create');
    Route::get('deleteCart',[UserController::class,'deleteCart']);
    Route::get('cart',[UserController::class,'cartPage'])->name('cart#page');
    Route::get('paymentPage',[UserController::class,'paymentPage']);
    Route::post('order',[UserController::class,'storeOrder'])->name('store#order');
    Route::get('tempStorage',[UserController::class,'tempStorage']);

    Route::group(['prefix' => 'order'],function(){
        Route::get('list',[UserController::class,'orderList'])->name('user#orderList');
        Route::get('detail/{order_code}',[UserController::class,'orderDetail'])->name('order#detail');
    });
});
