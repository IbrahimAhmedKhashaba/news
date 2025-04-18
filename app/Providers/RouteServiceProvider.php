<?php

namespace App\Providers;

use App\Traits\ApiResponseTrait;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    use ApiResponseTrait;
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/';
    public const DASHBOARD = 'admin/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('web')
                ->group(base_path('routes/admin.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->ip());
        });

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(4)->by($request->ip())->response(function()use($request){
                RateLimiter::increment($request->ip());
                return $this->apiResponse(null , 'Try again after '. RateLimiter::availableIn($request->ip()).' secondes' , 401);
            });
        });

        RateLimiter::for('user-data', function (Request $request) {
            return Limit::perMinute(2)->by($request->ip())->response(function()use($request){
                RateLimiter::increment($request->ip());
                return $this->apiResponse(null , 'Try again after '. RateLimiter::availableIn($request->ip()).' secondes' , 401);
            });
        });

        RateLimiter::for('store-post', function (Request $request) {
            return Limit::perMinute(1)->by($request->ip())->response(function()use($request){
                RateLimiter::increment($request->ip());
                return $this->apiResponse(null , 'Try again after '. RateLimiter::availableIn($request->ip()).' secondes' , 401);
            });
        });

        RateLimiter::for('get-user-posts', function (Request $request) {
            return Limit::perMinute(2)->by($request->ip())->response(function()use($request){
                RateLimiter::increment($request->ip());
                return $this->apiResponse(null , 'Try again after '. RateLimiter::availableIn($request->ip()).' secondes' , 401);
            });
        });

        RateLimiter::for('update-user-data', function (Request $request) {
            return Limit::perMinute(2)->by($request->ip())->response(function()use($request){
                RateLimiter::increment($request->ip());
                return $this->apiResponse(null , 'Try again after '. RateLimiter::availableIn($request->ip()).' secondes' , 401);
            });
        });

        RateLimiter::for('change-password', function (Request $request) {
            return Limit::perMinute(1)->by($request->ip())->response(function()use($request){
                RateLimiter::increment($request->ip());
                return $this->apiResponse(null , 'Try again after '. RateLimiter::availableIn($request->ip()).' secondes' , 401);
            });
        });

        RateLimiter::for('destroy-user-post', function (Request $request) {
            return Limit::perMinute(2)->by($request->ip())->response(function()use($request){
                RateLimiter::increment($request->ip());
                return $this->apiResponse(null , 'Try again after '. RateLimiter::availableIn($request->ip()).' secondes' , 401);
            });
        });

        RateLimiter::for('update-user-post', function (Request $request) {
            return Limit::perMinute(2)->by($request->ip())->response(function()use($request){
                RateLimiter::increment($request->ip());
                return $this->apiResponse(null , 'Try again after '. RateLimiter::availableIn($request->ip()).' secondes' , 401);
            });
        });

        RateLimiter::for('register', function (Request $request) {
            return Limit::perMinute(1)->by($request->ip())->response(function()use($request){
                RateLimiter::increment($request->ip());
                return $this->apiResponse(null , 'Try again after '. RateLimiter::availableIn($request->ip()).' secondes' , 401);
            });
        });

        RateLimiter::for('verify-email', function (Request $request) {
            return Limit::perMinute(2)->by($request->ip())->response(function()use($request){
                RateLimiter::increment($request->ip());
                return $this->apiResponse(null , 'Try again after '. RateLimiter::availableIn($request->ip()).' secondes' , 401);
            });
        });

        RateLimiter::for('resend-email-token', function (Request $request) {
            return Limit::perMinute(1)->by($request->ip())->response(function()use($request){
                RateLimiter::increment($request->ip());
                return $this->apiResponse(null , 'Try again after '. RateLimiter::availableIn($request->ip()).' secondes' , 401);
            });
        });

        RateLimiter::for('forget-password', function (Request $request) {
            return Limit::perMinute(2)->by($request->ip())->response(function()use($request){
                RateLimiter::increment($request->ip());
                return $this->apiResponse(null , 'Try again after '. RateLimiter::availableIn($request->ip()).' secondes' , 401);
            });
        });

        RateLimiter::for('reset-password', function (Request $request) {
            return Limit::perMinute(2)->by($request->ip())->response(function()use($request){
                RateLimiter::increment($request->ip());
                return $this->apiResponse(null , 'Try again after '. RateLimiter::availableIn($request->ip()).' secondes' , 401);
            });
        });

        RateLimiter::for('store-comment', function (Request $request) {
            return Limit::perMinute(4)->by($request->ip())->response(function()use($request){
                RateLimiter::increment($request->ip());
                return $this->apiResponse(null , 'Try again after '. RateLimiter::availableIn($request->ip()).' secondes' , 401);
            });
        });

        RateLimiter::for('contacts', function (Request $request) {
            return Limit::perMinutes(4 , 2)->by($request->ip())->response(function()use($request){
                RateLimiter::increment($request->ip());
                return $this->apiResponse(null , 'Try again after '. RateLimiter::availableIn($request->ip()).' secondes' , 401);
            });
        });
    }
}
