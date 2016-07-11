# laravel-schedule-monitor
Track the output of your scheduled tasks in a database table.

## Installation

1. Install through composer: `composer require mirzabusatlic/laravel-schedule-monitor`
2. Add `Busatlic\ScheduleMonitor\ScheduleMonitorServiceProvider::class` to your list of `$providers` in to your `config/app.php`.
3. Publish the migration using `php artisan vendor:publish --provider=Busatlic\\ScheduleMonitor\\ScheduleMonitorServiceProvider`.
4. Run `php artisan migrate` to create the `schedule_events` table in your database.

## Usage

- In your `app/Console/Kernel.php`, include use the `Busatlic\ScheduleMonitor\MonitorsSchedule` trait.
- Call `$this->monitor($schedule)` after you've defined your scheduled commands in `schedule()`.

This will look something like:

```php
<?php

namespace App\Console;

use Busatlic\ScheduleMonitor\MonitorsSchedule;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    use MonitorsSchedule;

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\DeleteFilesCommand::class,
        \App\Console\Commands\FlushEventsCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('files:delete')->dailyAt('00:05');
        
        $schedule->command('events:flush')->hourly();

        $this->monitor($schedule);
    }
}
```

Whenever a scheduled command is then run, the its output will be inserted into the `scheduled_events` table.

| Logged | Command | Output
|---|---|---|
| 2016-07-11 02:21:38 | files:delete | Deleted (6391/6391) total files.
