<?php

namespace Base\Framework\Providers;

use Base\Api\ObjectManagerInterface;
use Base\Api\ProviderInterface;

/**
 * Class ServiceProvider
 *
 * An implementation of {@see ProviderInterface}.
 * Extend this class whenever you want to register
 * components before the application logic starts.
 *
 * @package Base\Framework\Providers
 * @since 2020-05-08
 * @author Danny Damsky <dannydamsky99@gmail.com>
 */
abstract class ServiceProvider implements ProviderInterface
{
    /**
     * Used for registering dependency injection bindings.
     *
     * @var ObjectManagerInterface
     */
    protected ObjectManagerInterface $app;

    /**
     * ServiceProvider constructor.
     * @param ObjectManagerInterface $objectManager
     */
    final public function __construct(ObjectManagerInterface $objectManager)
    {
        $this->app = $objectManager;
    }
}