<?php

use Base\Api\ApplicationInterface;
use Base\Framework\App\ObjectManager;
use PHPUnit\Framework\TestCase;

/**
 * Class FunctionsTest
 *
 * A test case of the functions located in functions.php
 *
 * @since 2020-05-09
 * @author Danny Damsky <dannydamsky99@gmail.com>
 */
class FunctionsTest extends TestCase
{
    /**
     * @see __()
     */
    public function test_the_double_underscore_function(): void
    {
        $this->assertEquals('One, Two, Three', __('%1, %2, %3', 'One', 'Two', 'Three'));
    }

    /**
     * @see env()
     */
    public function test_the_env_helper_function(): void
    {
        // env() without arguments should return an array of all environment variables from the .env file.
        $env = env();
        $this->assertIsArray($env);
        $this->assertNotEmpty($env);

        // Generate a unique key that isn't part of the env array.
        $uniqueKey = md5(uniqid(mt_rand(), true));
        while (isset($env[$uniqueKey])) {
            $uniqueKey = md5(uniqid(mt_rand(), true));
        }

        // Assert that env() returns the default provided value when the key is not found.
        $this->assertEquals('default', env($uniqueKey, 'default'));

        // Retrieve the first key=>value pair from the env array.
        $firstKey = array_key_first($env);
        $firstVal = $env[$firstKey];

        // Assert that env() returns the correct value for the given key.
        $this->assertEquals($firstVal, env($firstKey));
    }

    /**
     * @see config()
     */
    public function test_the_config_helper_function(): void
    {
        // config() without arguments should return an array of all configurations.
        $config = config();
        $this->assertIsArray($config);
        $this->assertNotEmpty($config);

        // Generate a unique key that isn't part of the config array.
        $uniqueKey = md5(uniqid(mt_rand(), true));
        while (isset($config[$uniqueKey])) {
            $uniqueKey = md5(uniqid(mt_rand(), true));
        }

        // Assert that config() returns the default provided value when the key is not found.
        $this->assertEquals('default', config($uniqueKey, 'default'));

        // Retrieve the first key=>value pair from the config array.
        $firstKey = array_key_first($config);
        $firstVal = $config[$firstKey];

        // Assert that config() returns the correct value for the given key.
        $this->assertEquals($firstVal, config($firstKey));
    }

    /**
     * @see app()
     */
    public function test_the_app_helper_function(): void
    {
        // When not provided any arguments, app() should return an instance of the application.
        $this->assertInstanceOf(ApplicationInterface::class, app());

        // Create a binding to the object manager.
        $objectManager = ObjectManager::getInstance();
        $objectManager->bind('a', stdClass::class);

        // When one argument is provided, app() should return an instance of the provided argument (binding).
        $this->assertInstanceOf(stdClass::class, app('a'));

        // When two arguments are provided, app() will bind the first string to the second one
        // using the object manager.
        app('b', 'a');
        $this->assertInstanceOf(stdClass::class, $objectManager->get('b'));

        // When the third argument isn't provided, app should retrieve the shared instances of provided tags.
        $this->assertSame(app('b'), app('a'));

        // Assert that app() creates new instances when the third argument is false.
        $this->assertNotSame(app('b', null, false), app('a', null, false));
    }
}