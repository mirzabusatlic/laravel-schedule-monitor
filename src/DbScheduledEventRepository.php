<?php

namespace Busatlic\ScheduleMonitor;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DbScheduledEventRepository implements ScheduledEventRepository
{
    /**
     * Insert a scheduled event that ran.
     *
     * @param string $command
     * @param string $output
     *
     * @return bool
     */
    public function insert($command, $output)
    {
        DB::table('scheduled_events')->insert([
            'command'   => $command,
            'output'    => $output,
            'logged_at' => Carbon::now(),
        ]);

        return true;
    }
}