<?php

namespace App\Providers;

use App\Enums\UserRole;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/backend';

    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        URL::forceScheme('https');

        Blade::anonymousComponentNamespace('backend', 'backend');
        Blade::anonymousComponentNamespace('frontend', 'frontend');
        Blade::anonymousComponentNamespace('auth', 'auth');

        $this->bootAuth();
        $this->bootRoute();
    }

    public function bootAuth(): void
    {
        Gate::define('developer', fn ($user) => Str::endsWith($user->email, '@tiknil.com'));
        Gate::define('admin', fn ($user) => $user->role === UserRole::Admin);
    }

    public function bootRoute(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

    }
}
