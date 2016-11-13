<?php
/**
 * WellCart Platform
 *
 * @copyright  Copyright (c) 2016 WellCart Development Team    http://wellcart.org/
 * @license    http://www.opensource.org/licenses/BSD-3-Clause New BSD License
 */

declare(strict_types = 1);

namespace WellCart\SchemaMigration;

use DoctrineModule\Component\Console\Output\PropertyOutput;
use Interop\Container\ContainerInterface;
use Symfony\Component\Console\Input\StringInput;
use WellCart\ModuleManager\Feature\ModulePathProviderInterface;
use WellCart\ModuleManager\Feature\VersionProviderInterface;
use WellCart\ModuleManager\ModuleConfiguration;
use WellCart\SchemaMigration\Console\PhinxApplication;
use Zend\Console\Adapter\AdapterInterface as Console;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;

class Module implements
    BootstrapListenerInterface,
    ConfigProviderInterface,
    VersionProviderInterface,
    ModulePathProviderInterface,
    ConsoleUsageProviderInterface
{
    /**
     * @var string
     */
    const VERSION = '0.1.0';
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Retrieve module version
     *
     * @return string
     */
    final public function getVersion()
    {
        return self::VERSION;
    }

    public function onBootstrap(EventInterface $event)
    {
        $this->container = $event->getTarget()->getServiceManager();
    }

    /**
     * Define Console Help text
     *
     * @param  Console $console
     *
     * @return String
     */
    public function getConsoleUsage(Console $console)
    {
        /* @var $cli PhinxApplication */
        $cli = $this->container->get(PhinxApplication::class);
        $output = new PropertyOutput();
        $cli->run(new StringInput('list'), $output);
        return $output->getMessage();
    }

    /**
     * @return ModuleConfiguration
     */
    public function getConfig()
    {
        return new ModuleConfiguration([], true, __DIR__ . '/../config');
    }

    /**
     * Expected to return absolute path to module directory
     *
     * @return string
     */
    public function getAbsolutePath()
    {
        return str_replace('\\', DS, dirname(__DIR__)) . DS;
    }
}
