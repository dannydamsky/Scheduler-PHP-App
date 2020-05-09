<?php /** @noinspection PhpFullyQualifiedNameUsageInspection */

use PHPUnit\Framework\TestCase;

/**
 * Class ObjectManagerTest
 * @since 2020-05-09
 * @author Danny Damsky <dannydamsky99@gmail.com>
 * @see \Base\Framework\App\ObjectManager
 */
class ObjectManagerTest extends TestCase
{
    /**
     * @see \Base\Framework\App\ObjectManager::getInstance()
     */
    public function test_object_manager_is_singleton(): void
    {
        // Get one instance of object manager.
        $instance1 = \Base\Framework\App\ObjectManager::getInstance();

        // Get another instance of object manager.
        $instance2 = \Base\Framework\App\ObjectManager::getInstance();

        // Check to see that they're the same.
        $this->assertSame($instance1, $instance2);
    }

    /**
     * @see \Base\Framework\App\ObjectManager::bind()
     */
    public function test_object_manager_deep_class_bindings(): void
    {
        // Retrieve an instance of the object manager.
        $objectManager = \Base\Framework\App\ObjectManager::getInstance();

        // Bind tag "a" to the stdClass
        $objectManager->bind('a', stdClass::class);

        // Bind tag "b" to tag "a"
        $objectManager->bind('b', 'a');

        // Bind tag "c" to tag "b"
        $objectManager->bind('c', 'b');

        // Bind tag "d" to tag "c"
        $objectManager->bind('d', 'c');

        // Check that tag "d" returns an instance of stdClass
        $this->assertInstanceOf(stdClass::class, $objectManager->create('d'));
    }

    /**
     * @see \Base\Framework\App\ObjectManager::get()
     */
    public function test_object_manager_get_returns_shared_instance(): void
    {
        // Retrieve an instance of the object manager.
        $objectManager = \Base\Framework\App\ObjectManager::getInstance();

        // Get one instance of stdClass.
        $instance1 = $objectManager->get(stdClass::class);

        // Get another instance of stdClass.
        $instance2 = $objectManager->get(stdClass::class);

        // Check if those instances are the same.
        $this->assertSame($instance1, $instance2);
    }

    /**
     * @see \Base\Framework\App\ObjectManager::create()
     */
    public function test_object_manager_create_returns_new_instance(): void
    {
        // Retrieve an instance of the object manager.
        $objectManager = \Base\Framework\App\ObjectManager::getInstance();

        // Create one instance of stdClass.
        $instance1 = $objectManager->create(stdClass::class);

        // Create another instance of stdClass.
        $instance2 = $objectManager->create(stdClass::class);

        // Check if those instances are not the same.
        $this->assertNotSame($instance1, $instance2);
    }
}