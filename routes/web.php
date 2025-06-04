<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialLoginController;
require_once __DIR__.'/admin.php';
require_once __DIR__.'/user.php';

Route::get('/', function () {
    return view('authentication.login');
    // return view('auth.login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/auth/{provider}/redirect', [SocialLoginController::class,'redirect'])->name('socialLogin');
Route::get('/auth/{provider}/callback', [SocialLoginController::class,'callback'])->name('socialCallback');


require __DIR__.'/auth.php';
