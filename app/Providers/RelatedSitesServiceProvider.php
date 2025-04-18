<?php

namespace App\Providers;

use App\Models\RelatedNewsSite;
use Illuminate\Support\ServiceProvider;

class RelatedSitesServiceProvider extends ServiceProvider
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
        $related_sites = RelatedNewsSite::select('name' , 'url')->get();
        view()->share([
            'related_sites' => $related_sites
        ]);
    }
}
