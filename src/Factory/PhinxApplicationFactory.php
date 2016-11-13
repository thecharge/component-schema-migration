<?php
/**
 * WellCart Platform
 *
 * @copyright  Copyright (c) 2016 WellCart Development Team    http://wellcart.org/
 * @license    http://www.opensource.org/licenses/BSD-3-Clause New BSD License
 */

declare(strict_types = 1);

namespace WellCart\SchemaMigration\Factory;

use Interop\Container\ContainerInterface;
use WellCart\SchemaMigration\Console\PhinxApplication;

class PhinxApplicationFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $app = new PhinxApplication('0.1.0');
        $app->setAutoExit(false);
        $app->setCatchExceptions(false);
        return $app;
    }
}
