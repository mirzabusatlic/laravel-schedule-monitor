<?php

namespace Busatlic\ScheduleMonitor;

use Illuminate\Support\ServiceProvider;

class ScheduleMonitorServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/migrations');
    }
}