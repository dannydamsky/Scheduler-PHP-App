<?php

namespace Base\Framework\App;

use Base\Api\ObjectManagerInterface;
use Base\Exceptions\ClassNotFoundException;
use ReflectionClass;
use ReflectionException;
use function class_exists;

/**
 * Class ObjectManager
 *
 * Implementation of {@see ObjectManagerInterface}.
 *
 * Singleton used for managing dependency injection
 * for this application.
 *
 * @package Base\Framework\App
 * @since 2020-05-07
 * @author Danny Damsky <dannydamsky99@gmail.com>
 */
final class ObjectManager implements ObjectManagerInterface
{
    /**
     * The current instance of this class.
     *
     * @var ObjectManager|null
     */
    private static ?self $instance = null;

    /**
     * @inheritDoc
     */
    public static function getInstance(): ObjectManagerInterface
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * A map of strings as keys (Can be class names, to override specific classes in DI)
     * and class names as values.
     * Used to bind a single class instance to another.
     *
     * @var string[]
     */
    private array $bindings;

    /**
     * Object instances. With the class names as keys.
     *
     * @var object[]
     */
    private array $instances;

    /**
     * ObjectManager constructor.
     */
    private function __construct()
    {
        $this->instances = [ObjectManagerInterface::class => $this, self::class => $this];
    }

    /**
     * @inheritDoc
     */
    public function bind(string $tag, string $className): void
    {
        $this->bindings[$tag] = $className;
    }

    /**
     * Get the binding by the given tag.
     *
     * @param string $tag
     * @return string
     */
    private function getBindingByTag(string $tag): string
    {
        while (isset($this->bindings[$tag])) {
            $tag = $this->bindings[$tag];
        }
        return $tag;
    }

    /**
     * @inheritDoc
     * @throws ReflectionException
     */
    public function get(string $tag): object
    {
        $tag = $this->getBindingByTag($tag);
        if (!isset($this->instances[$tag])) {
            $instance = $this->create($tag);
            $this->instances[$tag] = $instance;
            return $instance;
        }
        return $this->instances[$tag];
    }

    /**
     * @inheritDoc
     * @throws ReflectionException
     */
    public function create(string $tag): object
    {
        $tag = $this->getBindingByTag($tag);
        return $this->initialize($tag);
    }

    /**
     * Return a new instance of the given class name.
     *
     * @param string $class
     * @return object
     * @throws ReflectionException
     */
    private function initialize(string $class): object
    {
        if (!class_exists($class)) {
            throw ClassNotFoundException::build($class);
        }
        $reflection = new ReflectionClass($class);
        return $reflection->newInstanceArgs(
            $this->getArgumentsForConstructor($reflection)
        );
    }

    /**
     * Initialize the arguments for the constructor
     * of the given reflection class instance.
     *
     * @param ReflectionClass $reflection
     * @return object[]
     * @throws ReflectionException
     */
    private function getArgumentsForConstructor(ReflectionClass $reflection): array
    {
        $constructor = $reflection->getConstructor();
        if ($constructor === null) {
            return [];
        }
        $arguments = [];
        foreach ($constructor->getParameters() as $parameter) {
            $arguments[] = $this->get($parameter->getClass()->getName());
        }
        return $arguments;
    }
}