<?php
/**
 * WellCart Platform
 *
 * @copyright  Copyright (c) 2016 WellCart Development Team    http://wellcart.org/
 * @license    http://www.opensource.org/licenses/BSD-3-Clause New BSD License
 */

declare(strict_types = 1);

namespace WellCart\SchemaMigration\Factory\Controller;

use Interop\Container\ContainerInterface;
use WellCart\SchemaMigration\Console\PhinxApplication;
use WellCart\SchemaMigration\Controller\ConsoleController;

class ConsoleControllerFactory
{
    public function __invoke(ContainerInterface $container): ConsoleController
    {
        $application = $container
            ->getServiceLocator()
            ->get(PhinxApplication::class);
        return new ConsoleController($application);
    }
}
