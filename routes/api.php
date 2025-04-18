<?php

use App\Http\Controllers\Api\Auth\EmailVerifyController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\Password\ForgetPasswordController;
use App\Http\Controllers\Api\Auth\Password\ResetPasswordController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Category\CategoryController;
use App\Http\Controllers\Api\Contact\ContactController;
use App\Http\Controllers\Api\General\GeneralController;
use App\Http\Controllers\Api\General\SettingController;
use App\Http\Controllers\Api\Notification\NotificationController;
use App\Http\Controllers\Api\Post\PostController;
use App\Http\Controllers\Api\Profile\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['auth:sanctum' , 'CheckUserStatus' , 'verified'])
    ->controller(ProfileController::class)
    ->prefix('account')
    ->group(function () {
        Route::get('/user', 'getUserData')->middleware(middleware: 'throttle:user-data');
        Route::post('/user/posts/store', 'store')->middleware(middleware: 'throttle:store-post');
        Route::get('/user/posts', 'getUserPosts')->middleware(middleware: 'throttle:get-user-posts');
        Route::put('/user', 'update')->middleware(middleware: 'throttle:update-user-data');
        Route::patch('/user/change-password', 'changePassword')->middleware(middleware: 'throttle:change-password');
        Route::delete('/user/posts/{slug}/delete', 'destroy')->middleware(middleware: 'throttle:destroy-user-post');
        Route::put('/user/posts/{slug}/update', 'updatePost')->middleware(middleware: 'throttle:update-user-post');
    });

Route::post('auth/register', [RegisterController::class, 'register'])->middleware(middleware: 'throttle:register');
Route::post('auth/login', [LoginController::class, 'login'])->middleware('throttle:login');
Route::delete('auth/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');

Route::post('auth/email/verify', [EmailVerifyController::class, 'verifyEmail'])->middleware(['auth:sanctum' , 'throttle:verify-email']);
Route::get('auth/email/verify', [EmailVerifyController::class, 'resendEmail'])->middleware('auth:sanctum' , 'throttle:resend-email-token');

Route::post('auth/password/email', [ForgetPasswordController::class, 'sendOtp'])->middleware('throttle:forget-password');
Route::post('auth/password/reset', [ResetPasswordController::class, 'reset'])->middleware('throttle:reset-password');

Route::get('home/posts/{keyword?}', [GeneralController::class, 'home']);
Route::controller(PostController::class)->group(function () {
    Route::get('/posts/{slug}/show', 'showPost');
    Route::middleware(['auth:sanctum' , 'CheckUserStatus' , 'verified'])->group(function () {
        Route::get('/posts/{slug}/comments', 'getAllComments');
        Route::post('/posts/{slug}/comments', 'storeComment')->middleware('throttle:store-comment');
    });
});

Route::controller(NotificationController::class)->middleware(['auth:sanctum' , 'CheckUserStatus' , 'verified'])->group(function () {
    Route::get('/notifications', 'index');
    Route::delete('/notifications/{id}', 'delete');
    Route::post('/notifications', 'deleteAll');
    Route::put('/notifications', 'markAllAsRead');
});

Route::controller(CategoryController::class)->group(function () {
    Route::get('/categories', 'getCategories');
    Route::get('/categories/{slug}/posts', 'getCategoryPosts');
});

Route::get('/settings', [SettingController::class, 'index']);
Route::post('/contacts', [ContactController::class, 'store'])->middleware('throttle:contacts');
