<?php /** @noinspection PhpFullyQualifiedNameUsageInspection */

use PHPUnit\Framework\TestCase;

/**
 * Class OperationTest
 * @since 2020-05-09
 * @author Danny Damsky <dannydamsky99@gmail.com>
 * @see \App\Models\Operation
 */
final class OperationTest extends TestCase
{
    /**
     * @see \Base\Models\Model::__construct()
     */
    public function test_data_mapping_and_retrieval_on_initialize(): void
    {
        // Create a random data payload for the operation model.
        $payLoad = [
            'entityId' => 1,
            'model' => 'App\\Test',
            'data' => serialize(['test']),
            'createdAt' => date('Y-m-d H:i:s')
        ];

        // Create an instance of the model using the payload.
        $operation = new \App\Models\Operation($payLoad);

        // Unserialize the data for the payload (Operation has unserialize() built-into the getData() method)
        $payLoad['data'] = unserialize($payLoad['data']);

        // Check that each value of the payload is equal to the associated getter in the operation model.
        foreach ($payLoad as $key => $value) {
            $getter = 'get' . ucfirst($key);
            $this->assertEquals($value, $operation->{$getter}());
        }
    }
}