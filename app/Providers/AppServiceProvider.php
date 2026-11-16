<?php

namespace App\Providers;

use App\Models\Wishlist;
use Illuminate\Auth\Events\Login;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        Gate::before(function ($user, $ability){
            return $user->hasRole('admin') ? true : null;
        });

        Event::listen(Login::class, function ($event) {
        $user = $event->user;

        if (session()->has('wishlist') && !empty(session()->get('wishlist'))) {
            $sessionWishlists = session()->get('wishlist', []);

            foreach ($sessionWishlists as $productId) {
                Wishlist::firstOrCreate([
                    'user_id' => $user->id,
                    'product_id' => $productId
                ]);
            }

            session()->forget('wishlist');
        }
    });
    }
}
