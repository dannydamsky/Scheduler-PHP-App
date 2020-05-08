<?php

namespace App\Console\Commands;

use App\Models\Cron;
use App\Models\Operation;
use App\Models\RandomData;
use Base\Console\Commands\Command;
use function __;

/**
 * Class ScheduleRandomDataUpdate
 *
 * Schedules a value to be updated for the random data table.
 *
 * @package App\Console\Commands
 * @since 2020-05-08
 * @author Danny Damsky <dannydamsky99@gmail.com>
 */
final class ScheduleRandomDataUpdate extends Command
{
    /**
     * Handle scheduling the modification of a random data
     * row with the given data.
     *
     * @param int $id
     * @param string $data
     */
    public function handle(int $id, string $data): void
    {
        echo __('Loading Random Data ...') . "\n";
        $randomData = new RandomData($id);
        $randomData->setValue($data);

        echo __('Creating operation ...') . "\n";
        Operation::create($randomData, Operation::OPERATION_TYPE_UPDATE);

        echo __('Creating and scheduling a cron ...') . "\n";
        Cron::create('operation:execute', '+1 hour');
    }
}