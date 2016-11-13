<?php
/**
 * WellCart Platform
 *
 * @copyright  Copyright (c) 2016 WellCart Development Team    http://wellcart.org/
 * @license    http://www.opensource.org/licenses/BSD-3-Clause New BSD License
 */

declare(strict_types = 1);

namespace WellCart\SchemaMigration\Factory\Router;

use Interop\Container\ContainerInterface;
use WellCart\SchemaMigration\Console\PhinxApplication;
use WellCart\SchemaMigration\Router\Route;

class RouteFactory
{
    public function __invoke(ContainerInterface $container): Route
    {
        $application = $container
            ->getServiceLocator()
            ->get(PhinxApplication::class);
        return new Route(
            $application,
            array(
                'controller' => 'SchemaMigration::Console',
                'action'     => 'command'
            )
        );
    }
}
