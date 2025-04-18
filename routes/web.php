<?php

use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\frontend\ContactController;
use App\Http\Controllers\frontend\CategoryController;
use App\Http\Controllers\frontend\dashboard\NotificationController;
use App\Http\Controllers\frontend\dashboard\ProfileController;
use App\Http\Controllers\frontend\dashboard\SettingController;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\frontend\NewsSubscriberController;
use App\Http\Controllers\frontend\PostController;
use App\Http\Controllers\frontend\SearchController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::fallback(function (){
    return view('errors.404');
});

Route::group([
    'as' => 'frontend.'
], function () {

    Route::get('frontend/', [HomeController::class, 'index'])->name('index');
    Route::post('/news-subscriber', [NewsSubscriberController::class, 'store'])->name('news.subscriber');
    Route::get('category/{slug}', CategoryController::class)->name('category.posts');
    Route::match(['get', 'post' ] , 'search', SearchController::class)->name('search');

    Route::controller(PostController::class)->name('post.')->prefix('post')->group(function () {
        Route::get('/{slug}', 'show')->name('show');
        Route::get('/comments/{slug}', 'getAllComments')->name('getAllComments');
        Route::post('/store', 'store')->name('comment.store')->middleware('CheckUserStatus');
    });

    Route::controller(ContactController::class)->prefix('contact')->group(function () {
        Route::get('/', 'index')->name('contact');
        Route::post('/store', 'store')->name('contact.store');
    });

    Route::prefix('account/')->name('dashboard.')->middleware(['auth' , 'verified' , 'CheckUserStatus'])->group(function () {
        Route::controller(ProfileController::class)->group(function () {
            Route::get('profile', 'index')->name('profile');
            Route::post('post/store', 'storePost')->name('post.store');
            Route::get('/{slug}/edit', 'edit')->name('post.edit');
            Route::patch('/{slug}/update', 'update')->name('post.update');
            Route::post('/image/delete', 'deleteAnImage')->name('post.deleteImage');
            Route::delete('/delete', 'delete')->name('post.delete');
            Route::get('/getComments/{id}', 'getComments')->name('post.getComments');
            Route::get('/getSettings', 'getSettings')->name('settings')->middleware(middleware: 'throttle:user-data');
        });

        Route::prefix('settings')->controller(SettingController::class)->middleware('CheckUserStatus')->group(function () {
            Route::get('/', 'index')->name('settings');
            Route::post('/update', 'update')->name('settings.update');
            Route::post('/changePassword', 'changePassword')->name('settings.changePassword');
        });

        Route::prefix('Notifications')->controller(NotificationController::class)->middleware('CheckUserStatus')->group(function () {
            Route::get('/', 'index')->name('notifications');
            Route::delete('/{id}/delete', 'delete')->name('notifications.delete');
            Route::delete('/deleteAll', 'deleteAll')->name('notifications.deleteAll');
            Route::post('/markAllAsRead', 'markAllAsRead')->name('notifications.markAllAsRead');
        });
    });

    Route::get('wait' , function(){
        return view('frontend.wait');
    })->name('frontend.wait');
});

Route::controller(VerificationController::class)->prefix('email')->name('verification.')->group(function () {
    Route::get('/verify', 'show')->name('notice');
    Route::get('/verify/{id}/{hash}', 'verify')->name('verify');
    Route::post('/resend', 'resend')->name('resend');
});
Route::redirect('/' , '/frontend');
Auth::routes();

Route::get('auth/{provider}/redirect', [SocialLoginController::class, 'redirect'])->middleware('web')->name('auth.socialite.redirect');
Route::get('auth/{provider}/callback', [SocialLoginController::class, 'callback'])->middleware('web')->name('auth.callback');