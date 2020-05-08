<?php

namespace App\Console\Commands;

use App\Models\Cron;
use App\Models\Operation;
use App\Models\RandomData;
use Base\Console\Commands\Command;
use function __;

/**
 * Class ScheduleRandomDataCreate
 *
 * Schedules a value to be created for the random data table.
 *
 * @package App\Console\Commands
 * @since 2020-05-08
 * @author Danny Damsky <dannydamsky99@gmail.com>
 */
final class ScheduleRandomDataCreate extends Command
{
    /**
     * Handle scheduling the creation of a random data
     * row with the given data.
     *
     * @param string $data
     */
    public function handle(string $data): void
    {
        echo __('Creating random data ...') . "\n";
        $randomData = new RandomData();
        $randomData->setValue($data);

        echo __('Creating operation ...') . "\n";
        Operation::create($randomData, Operation::OPERATION_TYPE_CREATE);

        echo __('Creating and scheduling a cron ...') . "\n";
        Cron::create('operation:execute', '+1 hour');
    }
}