<?php

namespace Base\Framework\Providers;

use Base\Api\ApplicationInterface;
use Base\Api\ConfigurationInterface;
use Base\Api\DirectoryListInterface;
use Base\Api\EnvironmentInterface;
use Base\Framework\App\Configuration;
use Base\Framework\App\DirectoryList;
use Base\Framework\App\Environment;
use Base\Framework\Application;
use function date_default_timezone_set;
use function ini_set;

/**
 * Class ApplicationProvider
 *
 * Configures application logic according to the "app" configuration settings.
 *
 * @package Base\Framework\Providers
 * @since 2020-05-08
 * @author Danny Damsky <dannydamsky99@gmail.com>
 */
final class ApplicationProvider extends ServiceProvider
{
    /**
     * @inheritDoc
     */
    public function register(): void
    {
        $this->app->bind(DirectoryListInterface::class, DirectoryList::class);
        $this->app->bind(EnvironmentInterface::class, Environment::class);
        $this->app->bind(ConfigurationInterface::class, Configuration::class);
        $this->app->bind(ApplicationInterface::class, Application::class);
    }

    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        /** @var ConfigurationInterface $config */
        $config = $this->app->get(ConfigurationInterface::class);
        ini_set('display_errors', $config->get('app.debug') ? 'On' : 'Off');
        date_default_timezone_set($config->get('app.timezone'));
        foreach ($config->get('app.aliases', []) as $tag => $class) {
            $this->app->bind($tag, $class);
        }
    }
}