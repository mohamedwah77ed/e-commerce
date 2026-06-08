<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Cart\CartServiceInterface;
use App\Services\Cart\UserCartService;
use App\Models\Setting;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CartServiceInterface::class, UserCartService::class);
    }

    public function boot()
{
    try {
        $settings = Setting::pluck('value', 'key');
        View::share('settings', $settings);
    } catch (\Exception $e) {
        View::share('settings', collect());
    }
}
}
