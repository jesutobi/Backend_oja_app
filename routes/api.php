<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\findcontroller;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\StatesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\UpdateUserController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\SaveProductController;
use App\Http\Controllers\PaymentDetailController;
use App\Http\Controllers\UploadFeatureController;
use App\Http\Controllers\UploadProductController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\UploadCategoryController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ShippingAddressController;
use App\Http\Controllers\EmailVerificationController;




Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/verify', [EmailVerificationController::class, 'verify']);
    Route::get('/user', [UpdateUserController::class, 'user']);
    Route::put('/update_user', [UpdateUserController::class, 'update_user']);
    Route::post('/add_shipping_address', [ShippingAddressController::class, 'add_shipping_address']);
    Route::get('/get_shipping_addresses', [ShippingAddressController::class, 'get_shipping_addresses']);
    Route::get('/single_shipping_address_detail/{id}', [ShippingAddressController::class, 'single_shipping_address_detail']);
    Route::put('/edit_shipping_addresses/{id}', [ShippingAddressController::class, 'edit_shipping_addresses']);
    Route::patch('/addresses/{id}/set_address_toDefault', [ShippingAddressController::class, 'set_address_toDefault']);
    Route::delete('/Delete_address/{id}', [ShippingAddressController::class, 'Delete_address']);
    Route::get('/default-address', [ShippingAddressController::class, 'getDefaultAddress']);
    Route::post('/UploadCategory', [UploadCategoryController::class, 'UploadCategory']);
    Route::post('/UploadFeature', [UploadFeatureController::class, 'UploadFeature']);
    Route::post('/UploadProduct', [UploadProductController::class, 'UploadProduct']);
    Route::post('/post_product_review/{id}', [ProductController::class, 'post_product_review']);
    Route::post('/place_order', [OrderDetailController::class, 'place_order']);
    Route::post('/payment_details', [PaymentDetailController::class, 'payment_details']);
    Route::get('/get_all_orders', [OrderDetailController::class, 'get_all_orders']);
    Route::get('/get_order_detail/{id}', [OrderDetailController::class, 'get_order_detail']);
    Route::delete('/delete_orders/{id}', [OrderDetailController::class, 'delete_orders']);
    Route::post('/save_product', [SaveProductController::class, 'save_product']);
    Route::get('/get_saved_product/{id}', [SaveProductController::class, 'get_saved_product']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [ForgotPasswordController::class, 'forgot_password']);
Route::post('/reset_password', [ForgotPasswordController::class, 'reset_password']);
Route::get('/auth/{provider}/redirect', [SocialAuthController::class, 'redirect']);
Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback']);
Route::get('/get_product_feature', [UploadFeatureController::class, 'get_product_feature']);
Route::get('/get_product_category', [UploadCategoryController::class, 'get_product_category']);
Route::get('/get_featured_product', [ProductController::class, 'get_featured_product']);
Route::get('/new_arrival', [ProductController::class, 'new_arrival']);
Route::get('/get_product_detail/{id}', [ProductController::class, 'get_product_detail']);
Route::get('/get_product_review/{id}', [ProductController::class, 'get_product_review']);
Route::get('/get_similar_products/{id}', [ProductController::class, 'get_similar_products']);
Route::get('/get_states', [StatesController::class, 'get_states']);
Route::get('/get_Products_By_Category/{id}', [UploadCategoryController::class, 'get_Products_By_Category']);
Route::get('/search', [findcontroller::class, 'search']);
Route::get('/search_Products_By_Category/{id}', [findcontroller::class, 'search_Products_By_Category']);
