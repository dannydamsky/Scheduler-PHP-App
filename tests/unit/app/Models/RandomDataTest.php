<?php

use PHPUnit\Framework\TestCase;

/**
 * Class RandomDataTest
 * @since 2020-05-09
 * @author Danny Damsky <dannydamsky99@gmail.com>
 * @see \App\Models\RandomData
 */
final class RandomDataTest extends TestCase
{
    /**
     * @see \Base\Models\Model::__construct()
     */
    public function test_data_mapping_and_retrieval_on_initialize(): void
    {
        // Create a random data payload for the random data model.
        $payLoad = [
            'entityId' => 1,
            'value' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus dictum commodo urna sed sodales. Nunc pulvinar sem ipsum, sit amet lobortis ligula maximus et. Integer maximus semper libero suscipit cursus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nunc pharetra tellus augue, et scelerisque dui imperdiet vel.',
        ];

        // Create an instance of the model using the payload.
        $randomData = new \App\Models\RandomData($payLoad);

        // Check that each value of the payload is equal to the associated getter in the random data model.
        foreach ($payLoad as $key => $value) {
            $getter = 'get' . ucfirst($key);
            $this->assertEquals($value, $randomData->{$getter}());
        }
    }
}