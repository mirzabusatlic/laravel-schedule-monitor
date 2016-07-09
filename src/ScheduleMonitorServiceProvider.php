<?php

namespace Busatlic\ScheduleMonitor;

use Illuminate\Support\ServiceProvider;

class ScheduleMonitorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/migrations/' => database_path('/migrations')], 'migrations');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerScheduledEventRepository();
    }

    /**
     * Register the scheduled event repository.
     */
    protected function registerScheduledEventRepository()
    {
        $this->app->bind(ScheduledEventRepository::class, DbScheduledEventRepository::class);
    }
}