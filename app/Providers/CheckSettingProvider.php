<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;

class CheckSettingProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        $settings = Setting::firstOr(function(){
            return Setting::create([
                'site_name' => 'News',
                'logo' => 'uploads/settings/logo.png',
                'favicon' => 'default',
                'email' => 'Ibrahim2025@gmail.com',
                'facebook' => 'https://www.facebook.com',
                'twitter' => 'https://www.twitter.com',
                'instagram' => 'https://www.instagram.com',
                'youtube' => "https://www.youtube.com",
                'country' => "Egypt",
                'city' => "Sohag",
                'street' => "El-Danan street",
                'phone' => "01124782711",
                'small_desc' => "lorem ipsum dolor sit amet consectetur adip",
            ]);
        });
        view()->share([
            'settings' => $settings,
        ]);
    }
}
