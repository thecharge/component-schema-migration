<?php
/**
 * WellCart Platform
 *
 * @copyright  Copyright (c) 2016 WellCart Development Team    http://wellcart.org/
 * @license    http://www.opensource.org/licenses/BSD-3-Clause New BSD License
 */

declare(strict_types = 1);

namespace WellCart\SchemaMigration\Manager;

use Zend\Console\Adapter\AbstractAdapter as ConsoleAdapter;
use Zend\Console\ColorInterface;
use Zend\Console\Prompt;

class PhinxManager implements ColorInterface
{
    /**
     * @var string Path to the wellcart-schema-migration command,
     */
    const PHINX_CMD = 'wellcart/component-schema-migration/bin/wellcart-schema-migration';

    /**
     * @var array
     */
    protected $config;

    /**
     * @var Console
     */
    protected $console;

    /**
     * Constructor
     *
     * @param  ConsoleAdapter $console
     * @param  array          $config
     *
     * @throws RuntimeException
     */
    public function __construct(ConsoleAdapter $console, $config = [])
    {
        $this->config = $config;
        $this->console = $console;
    }

    /**
     * Command pass-through
     *
     */
    public function command()
    {
        /**
         * Update argv's
         */
        $argv = $_SERVER['argv'];
        array_shift($_SERVER['argv']);


        $_SERVER['argv'][]
            = "--configuration={$this->config['schema-migration']['phinx-config']}";

        /**
         * Run Phinx
         */
        if (is_file(WELLCART_VENDOR_PATH . self::PHINX_CMD)) {
            require WELLCART_VENDOR_PATH . self::PHINX_CMD;
        } else {
            require WELLCART_BIN_PATH . 'wellcart-schema-migration';
        }


        /**
         * Shift argv's
         */
        $_SERVER['argv'] = $argv;
    }
}
