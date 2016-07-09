<?php

namespace Busatlic\ScheduleMonitor;

interface ScheduledEventRepository
{
    /**
     * Insert a scheduled event that ran.
     *
     * @param string $command
     * @param string $output
     *
     * @return bool
     */
    public function insert($command, $output);
}