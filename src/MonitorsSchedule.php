<?php

namespace Busatlic\ScheduleMonitor;

use Carbon\Carbon;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Container\Container;
use Illuminate\Support\Collection;

trait MonitorsSchedule
{
    /**
     * Monitor each of the scheduled events.
     *
     * @param Schedule $schedule
     */
    public function monitor(Schedule $schedule)
    {
        $date = Carbon::today()->toDateString();

        $events = $this->getEvents($schedule);

        $events->each(function (Event $event) use ($date) {

            $command = $this->getCommand($event);

            $filename = str_slug($command) . "-$date.log";

            $path = storage_path("logs/$filename");

            $event->sendOutputTo($path)->after(function () use ($command, $path) {

                $output = file_get_contents($path);

                $this->getRepository()->insert($command, $output);
            });
        });
    }

    /**
     * Get the command from the event.
     *
     * @param Event $event
     *
     * @return string
     */
    private function getCommand(Event $event)
    {
        // Return everything that comes after 'artisan'.
        return substr($event->command, strpos($event->command, 'artisan') + strlen('artisan') + 1);
    }

    /**
     * Get the collection of events.
     *
     * @param Schedule $schedule
     *
     * @return Collection
     */
    private function getEvents(Schedule $schedule)
    {
        return new Collection($schedule->events());
    }

    /**
     * Get an instance of the ScheduledEventRepository.
     *
     * @return ScheduledEventRepository
     */
    private function getRepository()
    {
        return Container::getInstance()->make(ScheduledEventRepository::class);
    }
}