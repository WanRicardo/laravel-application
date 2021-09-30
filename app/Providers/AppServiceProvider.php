<?php

namespace App\Providers;

use App\Http\ViewComposers\ActivityComposer;
use App\View\Components\Badge;
use App\View\Components\Card;
use App\View\Components\Errors;
use App\View\Components\Tags;
use App\View\Components\Updated;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Blade::component('badge', Badge::class);
        Blade::component('updated', Updated::class);
        Blade::component('card', Card::class);
        Blade::component('tags', Tags::class);
        Blade::component('errors', Errors::class);

        // view()->composer('*', ActivityComposer::class);
        view()->composer(['posts.index', 'posts.show'], ActivityComposer::class);
    }
}
