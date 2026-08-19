<?php
use App\Http\Controllers\frontend\CartController;
use App\Http\Controllers\frontend\CustomerController;
use App\Http\Controllers\frontend\HomeController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

// Customer Authentication

Route::group(['middleware' => 'guest:customer'], function () {
    Route::get('/customer/login', [CustomerController::class, 'loginCustomer'])->name('customer.login');
    Route::post('/customer/login', [CustomerController::class, 'loginCheck'])->name('customer.login.process');
    Route::get('/customer/register', [CustomerController::class, 'registration'])->name('customer.register');
    Route::post('/customer/register', [CustomerController::class, 'customerRegistration'])->name('customer.register.store');
});

Route::post('/add-to-cart',[CartController::class,'add'])->name('cart.add');
Route::post('/update-to-cart',[CartController::class,'update'])->name('cart.updat');
Route::post('/delete-to-cart',[CartController::class,'remove'])->name('cart.delete');
Route::get('/get-cart-data',[CartController::class,'get_cart_data'])->name('cart.get');
Route::get('/cart-clear',[CartController::class,'clearCart'])->name('cart.clear');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [HomeController::class, 'allproducts'])->name('all.products');
Route::get('/get-product',[HomeController::class,'getProducts'])->name('get.products');
Route::get('/product-detail/{slug}', [HomeController::class, 'getProductDetail'])->name('get_product_detail');
Route::get('/checkout-page', [HomeController::class, 'checkoutPage'])->name('checkout_page');
Route::post('/store-order', [HomeController::class, 'storeOrder'])->name('store_order');
Route::get('/search-get-product',[HomeController::class,'getSearchProducts'])->name('get_search_product');



Route::group(['middleware' => 'auth:customer'], function () {
    Route::get('/profile', [CustomerController::class, 'dashboard'])->name('dashboard');
    Route::post('/profile', [CustomerController::class, 'updateCustomer'])->name('profile.update');
    Route::get('/all-orders', [CustomerController::class, 'allOrders'])->name('customer.all.order');
    Route::post('/delete-orders/{id}', [CustomerController::class, 'destroy_order'])->name('customer.order.delete');
    Route::get('/show-order-invoice/{id}', [CustomerController::class, 'order_invoice'])->name('customer.order.invoice');

    Route::get('/customer-logout', [CustomerController::class, 'userLogout'])->name('customer.logout');
});


// Authentication
// Route::group(['middleware' => 'guest'], function () {
//     Route::get('/login', [AuthenticationController::class, 'showLogin'])->name('admin');
//     Route::post('/login', [AuthenticationController::class, 'loginCheck'])->name('admin.login');
//      Route::get('/login', [AuthenticationController::class, 'showLogin'])->name('login');
// });

Route::get('/clear-all', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return 'Laravel cache cleared successfully.';
});


