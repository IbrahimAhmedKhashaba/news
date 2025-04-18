<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\ServiceProvider;

class CategoriesServiceProvider extends ServiceProvider
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
        $categories = Category::active()->with(['posts'=> function($query){
            $query->active();
        }
        ])->select('id' , 'name' , 'slug')->get();
        view()->share([
            'categories' => $categories
        ]);
    }
}
