<?php

namespace App\Console\Commands;

use App\Models\Cron;
use Base\Console\Commands\Command;
use function __;
use function config;
use function date;

/**
 * Class CronRun
 *
 * Runs the pending cron commands.
 *
 * @package App\Console\Commands
 * @since 2020-05-08
 * @author Danny Damsky <dannydamsky99@gmail.com>
 */
final class CronRun extends Command
{
    /**
     * Handle the execution of the cron command.
     */
    public function handle(): void
    {
        /** @var Cron[] $crons */
        $crons = Cron::getAll([
            'scheduledAt' => ['le' => date('Y-m-d H:i:s')],
            'executedFrom' => ['is' => 'NULL']
        ]);
        $commands = config('app.commands', []);
        foreach ($crons as $cron) {
            $cron->setExecutedFrom(date('Y-m-d H:i:s'));
            $commandName = $cron->getCommand();
            if (isset($commands[$commandName])) {
                /** @var Command $command */
                $command = app($commands[$commandName]);
                echo __('Running command "%1" ...', $commandName) . "\n";
                $command->execute([]);
            }
            $cron->setExecutedTo(date('Y-m-d H:i:s'));
            $cron->save();
        }
    }
}