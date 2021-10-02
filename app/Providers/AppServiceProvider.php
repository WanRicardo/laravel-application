<?php

namespace App\Providers;

use App\Http\ViewComposers\ActivityComposer;
use App\Models\BlogPost;
use App\Models\Comment;
use App\Observers\BlogPostObserver;
use App\Observers\CommentObserver;
use App\Services\Counter;
use App\Services\DummyCounter;
use App\View\Components\Badge;
use App\View\Components\Card;
use App\View\Components\CommentForm;
use App\View\Components\CommentList;
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
        Blade::component('comment-form', CommentForm::class);
        Blade::component('comment-list', CommentList::class);

        // view()->composer('*', ActivityComposer::class);
        view()->composer(['posts.index', 'posts.show'], ActivityComposer::class);

        BlogPost::observe(BlogPostObserver::class);
        Comment::observe(CommentObserver::class);

        $this->app->singleton(Counter::class, function($app) {
            return new Counter(
                $app->make('Illuminate\Contracts\Cache\Factory'),
                $app->make('Illuminate\Contracts\Session\Session'),
                env('COUNTER_TIMEOUT')
            );
        });

        // $this->app->bind(
        //     'App\Contracts\CounterContract',
        //     DummyCounter::class
        // );

        $this->app->bind(
            'App\Contracts\CounterContract',
            Counter::class
        );

        // $this->app->when(Counter::class)
        //     ->needs('$timeout')
        //     ->give(env('COUNTER_TIMEOUT'));
    }
}
