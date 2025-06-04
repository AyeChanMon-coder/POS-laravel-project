<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\CategoryController;

Route::group(['prefix' => 'admin', 'middleware' => 'adminMiddleware'],function(){
    Route::get('dashboard',[AdminController::class, 'adminHome'])->name('main#dashboard');
    Route::group(['prefix'=> 'category'], function(){
        Route::get('list', [CategoryController::class, 'categoryPage'])->name('category#page');
        Route::post('categoryCreate', [CategoryController::class, 'create'])->name('category#create');
        Route::get('categoryDelete/{id}', [CategoryController::class, 'delete'])->name('category#delete');
        Route::get('categoryEdit/{id}', [CategoryController::class, 'edit'])->name('category#edit');
        Route::post('categoryEdit/{id}', [CategoryController::class, 'update'])->name('category#update');
    });
    Route::group(['prefix' => 'product'],function(){
        Route::get('create',[ProductController::class,'create'])->name('product#create');
        Route::post('store',[ProductController::class,'store'])->name('product#store');
        Route::get('list/{action?}',[ProductController::class,'list'])->name('product#list');
        Route::get('delete/{id}',[ProductController::class,'delete'])->name('product#delete');
        Route::get('edit/{id}',[ProductController::class,'edit'])->name('product#editPage');
        Route::post('update',[ProductController::class,'update'])->name('product#update');
        Route::get('detail/{id}',[ProductController::class,'detail'])->name('product#detail');
    });
    Route::group(['prefix' => 'profile'], function(){
        Route::get('edit',[ProfileController::class,'profileEdit'])->name('profile#editPage');
        Route::post('edit',[ProfileController::class,'profileUpdate'])->name('profile#update');
        Route::get('changePassword',[ProfileController::class,'changePassword'])->name('password#changePage');
        Route::post('changePassword',[ProfileController::class,'changePasswordProcess'])->name('password#edit');
    });
    Route::group(['prefix' => 'order'],function(){
        Route::get('list',[OrderController::class,'orderList'])->name('admin#orderList');
        Route::get('detail/{order_code}',[OrderController::class,'orderDetail'])->name('admin#orderDetail');
        Route::get('statusChange',[OrderController::class,'changeStatus']);
        Route::get('statusConfirm',[OrderController::class,'confirmStatus']);

    });
    Route::group(['prefix' => 'sale'],function(){
        Route::get('info',[SaleController::class,'saleInfo'])->name('sale#page');
    });
    Route::group(['middleware'=>'superadminMiddleware'], function(){
        Route::group(['prefix' => 'payment'], function(){
            Route::get('paymentList',[PaymentController::class,'list'])->name('payment#list');
            Route::post('paymentCreate',[PaymentController::class,'create'])->name('payment#create');
            Route::get('paymentDelete/{id}',[PaymentController::class,'delete'])->name('payment#delete');
            Route::get('paymentEdit/{id}',[PaymentController::class,'edit'])->name('payment#edit');
            Route::post('paymentUpdate',[PaymentController::class,'update'])->name('payment#update');
        });
        Route::group(['prefix' => 'account'],function(){
            Route::get('newAdmin',[AdminController::class,'newAdminPage'])->name('newAdmin#page');
            Route::post('newAdmin',[AdminController::class,'createAdmin'])->name('newAdmin#create');
            Route::get('adminList',[AdminController::class,'adminList'])->name('admin#list');
            Route::get('userList',[AdminController::class,'userList'])->name('user#list');
            Route::get('adminDelete/{id}',[AdminController::class,'adminDelete'])->name('admin#delete');
            Route::get('userDelete/{id}',[AdminController::class,'userDelete'])->name('user#delete');



        });
    });
});

