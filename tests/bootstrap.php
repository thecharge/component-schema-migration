<?php
/**
 * WellCart Platform
 *
 * @copyright  Copyright (c) 2016 WellCart Development Team    http://wellcart.org/
 * @license    http://www.opensource.org/licenses/BSD-3-Clause New BSD License
 */

declare(strict_types = 1);

namespace WellCart\SchemaMigration\Test;

use Codeception\Util\Autoload as CodeceptionAutoload;
use josegonzalez\Dotenv\Loader as Dotenv;
use RuntimeException;
use WellCart\Mvc\Application;
use WellCart\Utility\Config;
use WellCart\Utility\PHPEnvironment;

if (is_file(__DIR__ . '/../../../bootstrap.php')) {
    require_once __DIR__ . '/../../../bootstrap.php';
}
CodeceptionAutoload::addNamespace(
    'WellCart\SchemaMigration\Test',
    __DIR__ . '/support'
);

if (!defined('WELLCART')) {
    define('WELLCART', true);
    chdir(__DIR__);
    /**
     * Bootstrap module tests
     */
    Bootstrap::init();
}

/**
 * Bootstrap test environment
 *
 * @package  WellCart\SchemaMigration
 */
class Bootstrap
{
    /**
     * Initialize testing environment
     *
     * @return void
     */
    public static function init()
    {
        if (is_file(__DIR__ . '/config/.env')) {
            Dotenv::load(
                [
                    'filepath' => __DIR__ . '/config/.env',
                    'toEnv'    => true,
                ]
            );
        }

        // Define application environment
        if (!isset($_ENV['WELLCART_APPLICATION_ENV'])) {
            $_ENV['WELLCART_APPLICATION_ENV'] = getenv(
                'WELLCART_APPLICATION_ENV'
            ) ?: 'testing';
        }

        // Load the user-defined test configuration file, if it exists; otherwise, load
        if (is_readable(__DIR__ . '/config/application.config.php')) {
            $testConfig = __DIR__ . '/config/application.config.php';
        } else {
            $testConfig = __DIR__ . '/config/application.config.php.dist';
        }

        static::initAutoloader();

        defined('WELLCART_ROOT')
        || define(
        'WELLCART_ROOT', (getenv('WELLCART_ROOT')
            ? getenv('WELLCART_ROOT')
            : str_replace('\\', '/', __DIR__) . '/')
        );

        defined('WELLCART_BIN_PATH')
        || define(
        'WELLCART_BIN_PATH', (getenv('WELLCART_BIN_PATH') ? getenv(
            'WELLCART_BIN_PATH'
        ) : static::findParentPath('bin'))
        );

        // Define application context
        if (!is_file(WELLCART_ROOT . 'config/autoload/installed.php')) {
            $_ENV['WELLCART_APPLICATION_CONTEXT'] = Application::CONTEXT_SETUP;
        } elseif (empty($_ENV['WELLCART_APPLICATION_CONTEXT'])) {
            $_ENV['WELLCART_APPLICATION_CONTEXT'] = Application::CONTEXT_GLOBAL;
        }

        /**
         * Setup initial PHP environment
         */
        PHPEnvironment::initialize();

        $app = Application::init(
            Config::application(include $testConfig)
        );
        application($app);
    }

    /**
     * Init autoloader
     *
     * @throws \RuntimeException
     */
    protected static function initAutoloader()
    {
        $vendorPath = static::findParentPath('vendor');
        if (is_readable($vendorPath . 'autoload.php')) {
            defined('WELLCART_VENDOR_PATH')
            || define('WELLCART_VENDOR_PATH', $vendorPath);
            include $vendorPath . 'autoload.php';
        } else {
            throw new RuntimeException(
                "Unable to load WellCart Platform. Run `composer install`.\n"
            );
        }
    }

    /**
     * Find parent path
     *
     * @param $path
     *
     * @return bool|string
     */
    protected static function findParentPath($path)
    {
        $dir = __DIR__;
        $previousDir = '.';
        while (!is_dir($dir . '/' . $path)) {
            $dir = dirname($dir);
            if ($previousDir === $dir) {
                return false;
            }
            $previousDir = $dir;
        }
        return str_replace('\\', '/', $dir . '/' . $path) . '/';
    }
}