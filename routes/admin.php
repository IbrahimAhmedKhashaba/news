<?php

use App\Http\Controllers\Admin\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\Password\ForgetPasswordController;
use App\Http\Controllers\Admin\Auth\Password\ResetPasswordController;
use App\Http\Controllers\Admin\Authorization\AuthorizationController;
use App\Http\Controllers\Admin\Category\CategoryController;
use App\Http\Controllers\Admin\Contact\ContactController;
use App\Http\Controllers\Admin\GeneralSearchController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\Notification\NotificationController;
use App\Http\Controllers\Admin\Post\PostController;
use App\Http\Controllers\Admin\Profile\ProfileController;
use App\Http\Controllers\Admin\Setting\RelatedSitesController;
use App\Http\Controllers\Admin\Setting\SettingController;
use App\Http\Controllers\Admin\User\UserController;
use Illuminate\Support\Facades\Route;



Route::group(['prefix' => 'admin' , 'as' => 'admin.'] , function (){
    Route::controller(LoginController::class)->group(function (){
        Route::middleware('guest:admin')->group(function (){
            Route::get('login/show' , 'show')->name('login.show');
            Route::post('login' , 'login')->name('login');
        });
        Route::middleware('auth:admin')->group(function (){
            Route::post('logout' , 'logout')->name('logout');
        });
    });

    Route::group(['prefix' => 'password' , 'as' => 'password.' , 'middleware' => 'guest:admin'] , function (){
        Route::controller(ForgetPasswordController::class)->group(function (){
            Route::get('email' , 'showEmailForm')->name('email');
        Route::post('sendOtp' , 'sendOtp')->name('sendOtp');
        Route::get('confirm/{email}' , 'confirm')->name('confirm');
        Route::post('verify' , 'verify')->name('verify');
        });
        
        Route::controller(ResetPasswordController::class)->group(function (){
            Route::get('reset/{email}' , 'reset')->name('reset');
            Route::post('reset/update' , 'updatePassword')->name('reset.update');
        });
    });
});


Route::group(['prefix' => 'admin' , 'as' => 'admin.' , 'middleware' => ['auth:admin' , 'CheckAdminStatus']], function () {
    
    Route::resource('authorizations' , AuthorizationController::class);
    
    Route::resource('users' , UserController::class);
    Route::get('users/updateStatus/{id}' , [UserController::class , 'updateStatus'])->name('users.updateStatus');
    
    Route::resource('categories' , CategoryController::class);
    Route::get('categories/updateStatus/{id}' , [CategoryController::class , 'updateStatus'])->name('categories.updateStatus');
    
    Route::resource('posts' , PostController::class);
    Route::get('posts/updateStatus/{id}' , [PostController::class , 'updateStatus'])->name('posts.updateStatus');
    Route::get('posts/getAllComments/{id}' , [PostController::class , 'getAllComments'])->name('posts.getAllComments');
    Route::post('/image/delete', [PostController::class , 'deleteAnImage'])->name('post.deleteImage');
    Route::delete('/comment/delete/{id}', [PostController::class , 'deleteComment'])->name('post.deleteComment');
    
    Route::controller(ProfileController::class)->prefix('profile')->as('profile.')->group(function (){
        Route::get('/' , 'index')->name('index');
        Route::post('/update' , 'update')->name('update');
    });

    Route::controller(NotificationController::class)->prefix('notifications')->as('notifications.')->group(function (){
        Route::get('/' , 'index')->name('index');
        Route::delete('/destroy/{id}' , 'destroy')->name('destroy');
        Route::delete('/deleteAll' , 'deleteAll')->name('deleteAll');
    });

    Route::resource('related_sites' , RelatedSitesController::class);

    Route::controller(SettingController::class)->prefix('settings')->as('settings.')->group(function (){
        Route::get('/' , 'index')->name('index');
        Route::post('/update' , 'update')->name('update');
    });

    Route::controller(ContactController::class)->prefix('contacts')->as('contacts.')->group(function (){
        Route::get('/' , 'index')->name('index');
        Route::get('/show/{id}' , 'show')->name('show');
        Route::delete('/destroy/{id}' , 'destroy')->name('destroy');
    });

    Route::get('/search', GeneralSearchController::class)->name('search');

    Route::resource('admins' , AdminController::class);
    Route::get('admins/updateStatus/{id}' , [AdminController::class , 'updateStatus'])->name('admins.updateStatus');

    Route::get('/home' , [HomeController::class , 'index'])->name('home');
});

// Route::redirect('/' , 'admin/home');

