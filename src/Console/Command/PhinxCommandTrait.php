<?php
/**
 * WellCart Platform
 *
 * @copyright  Copyright (c) 2016 WellCart Development Team    http://wellcart.org/
 * @license    http://www.opensource.org/licenses/BSD-3-Clause New BSD License
 */

declare(strict_types = 1);

namespace WellCart\SchemaMigration\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use WellCart\SchemaMigration\Migration\Manager;

trait PhinxCommandTrait
{
    /**
     * Load the migrations manager and inject the config
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function loadManager(
        InputInterface $input,
        OutputInterface $output
    ) {
        if (null === $this->getManager()) {
            $manager = new Manager($this->getConfig(), $input, $output);
            $this->setManager($manager);
        }
    }

    /**
     * Returns config file path
     *
     * @param InputInterface $input
     *
     * @return string
     */
    protected function locateConfigFile(InputInterface $input)
    {
        $configFile = $input->getOption('configuration');
        if (null === $configFile || false === $configFile) {
            $input->setOption(
                'configuration',
                realpath(__DIR__ . '/../../../config/phinx.php')
            );
            $input->setOption('parser', 'php');
        }

        return parent::locateConfigFile($input);
    }
}
