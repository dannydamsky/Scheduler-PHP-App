<?php

namespace App\Console\Commands;

use App\Models\Cron;
use App\Models\Operation;
use App\Models\RandomData;
use Base\Console\Commands\Command;
use function __;

/**
 * Class ScheduleRandomDataDelete
 *
 * Schedules a value to be deleted for the random data table.
 *
 * @package App\Console\Commands
 * @since 2020-05-08
 * @author Danny Damsky <dannydamsky99@gmail.com>
 */
final class ScheduleRandomDataDelete extends Command
{
    /**
     * Handle scheduling the deletion of a random data
     * row with the given data.
     *
     * @param int $id
     */
    public function handle(int $id): void
    {
        echo __('Loading Random Data ...') . "\n";
        $randomData = new RandomData($id);

        echo __('Creating operation ...') . "\n";
        Operation::create($randomData, Operation::OPERATION_TYPE_DELETE);

        echo __('Creating and scheduling a cron ...') . "\n";
        Cron::create('operation:execute', '+1 hour');
    }
}