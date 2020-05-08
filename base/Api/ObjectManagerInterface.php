<?php

namespace Base\Api;

/**
 * Interface ObjectManagerInterface
 *
 * This interface should be implemented
 * by the component handling the dependency injection
 * for this application.
 *
 * The dependency injection component is used to initialize
 * instances of classes along with their dependencies.
 *
 * @package Base\Api
 * @since 2020-05-08
 * @author Danny Damsky <dannydamsky99@gmail.com>
 */
interface ObjectManagerInterface
{
    /**
     * Get the object manager instance.
     */
    public static function getInstance(): self;

    /**
     * Create a binding of the original class/tag to the given class name.
     *
     * @param string $tag Either a class name or some other string used to bind a class to it.
     * @param string $className The name of the class to bind the given tag to.
     */
    public function bind(string $tag, string $className): void;

    /**
     * Retrieve the given class/tag's instance. (Singleton)
     *
     * @param string $tag
     * @return object
     */
    public function get(string $tag): object;

    /**
     * Create the given class/tag's instance and return it.
     *
     * @param string $tag
     * @return object
     */
    public function create(string $tag): object;
}