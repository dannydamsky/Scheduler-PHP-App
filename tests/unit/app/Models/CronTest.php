<?php /** @noinspection PhpFullyQualifiedNameUsageInspection */

use PHPUnit\Framework\TestCase;

/**
 * Class CronTest
 * @since 2020-05-09
 * @author Danny Damsky <dannydamsky99@gmail.com>
 * @see \App\Models\Cron
 */
final class CronTest extends TestCase
{
    /**
     * @see \Base\Models\Model::__construct()
     */
    public function test_data_mapping_and_retrieval_on_initialize(): void
    {
        // Create a random data payload for the cron model.
        $payLoad = [
            'entityId' => 1,
            'command' => 'test',
            'scheduledAt' => date('Y-m-d H:i:s'),
            'executedFrom' => date('Y-m-d H:i:s', strtotime('+1 hour')),
            'executedTo' => date('Y-m-d H:i:s', strtotime('+2 hours')),
            'createdAt' => date('Y-m-d H:i:s', strtotime('-1 hour')),
            'updatedAt' => date('Y-m-d H:i:s', strtotime('+2 hours'))
        ];

        // Create an instance of the model using the payload.
        $cron = new \App\Models\Cron($payLoad);

        // Check that each value of the payload is equal to the associated getter in the cron model.
        foreach ($payLoad as $key => $value) {
            $getter = 'get' . ucfirst($key);
            $this->assertEquals($value, $cron->{$getter}());
        }
    }
}