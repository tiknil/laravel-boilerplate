<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Bugsnag::setAppVersion(trans('generic.app_version'));
        Bugsnag::setHostname(env('APP_URL'));
        Bugsnag::setReleaseStage(env('APP_ENV'));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->alias('bugsnag.multi', \Illuminate\Contracts\Logging\Log::class);
        $this->app->alias('bugsnag.multi', \Psr\Log\LoggerInterface::class);
    }
}
