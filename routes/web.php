<?php

use App\Http\Controllers\admin\AuthenticationController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\frontend\HomeController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;



Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/product-detail/{slug}',[HomeController::class,'getProductDetail'])->name('get_product_detail');



// Authentication
Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [AuthenticationController::class, 'showLogin'])->name('admin');
    Route::post('/login', [AuthenticationController::class, 'loginCheck'])->name('admin.login');
    //  Route::get('/login', [AuthenticationController::class, 'showLogin'])->name('login');
});

Route::get('/clear-all', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return 'Laravel cache cleared successfully.';
});

Route::group(['middleware' => 'auth'], function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');

    // Update Profile
    Route::get('/profile', [AuthenticationController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile/update', [AuthenticationController::class, 'updateProfile'])->name('profile.update');

    // Change Password
    Route::get('/change-password', [AuthenticationController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/change-password', [AuthenticationController::class, 'updatePassword'])->name('password.update');

    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::put('/users/update-status/{id}', [UserController::class, 'updateStatus'])->name('users.updateStatus');
    Route::delete('/users/destroy/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // User Access
    Route::put('/user/{user}/access', [UserController::class, 'updateAccess'])->name('user.access.update');

  

    // settings
    Route::get('/setting', [SettingController::class, 'setting'])->name('setting');
    Route::put('/setting', [SettingController::class, 'update'])->name('setting.update');

});
