<?php

namespace App\Console\Commands;

use App\Models\Cron;
use App\Models\Operation;
use App\Models\RandomData;
use Base\Console\Commands\Command;
use function __;
use function date;
use function strtotime;

/**
 * Class ScheduleRandomDataCreate
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
        $operation = new Operation();
        $operation->setData($randomData->toArray());
        $operation->setModel(RandomData::class);
        $operation->setType(Operation::OPERATION_TYPE_CREATE);
        $operation->save();

        echo __('Creating and scheduling a cron ...') . "\n";
        $cron = new Cron();
        $cron->setCommand('operation:execute');
        $cron->setScheduledAt(date('Y-m-d H:i:s', strtotime('+1 hour')));
        $cron->save();
    }
}