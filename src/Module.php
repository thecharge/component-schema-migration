<?php
/**
 * WellCart Platform
 *
 * @copyright  Copyright (c) 2016 WellCart Development Team    http://wellcart.org/
 * @license    http://www.opensource.org/licenses/BSD-3-Clause New BSD License
 */

declare(strict_types = 1);

namespace WellCart\SchemaMigration;

use WellCart\ModuleManager\Feature\ModulePathProviderInterface;
use WellCart\ModuleManager\Feature\VersionProviderInterface;
use Zend\Console\Adapter\AdapterInterface as Console;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;

class Module implements
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
     * Retrieve module version
     *
     * @return string
     */
    final public function getVersion()
    {
        return self::VERSION;
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
        return [
            'Schema Migration commands',
            'wellcart:schema-migration'                  => "List the Phinx console usage information.",
            'wellcart:schema-migration <phinx commands>' => "Run the specified Phinx command (run 'wellcart-schema-migration' for the commands list).",

            ['--overwrite',
             "Will force the setup tool to run and overwrite any existing configuration."],
            ['<phinx commands>',
             "Any support Phinx commands - will be passed through to Phinx as-is."],
        ];
    }

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
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
