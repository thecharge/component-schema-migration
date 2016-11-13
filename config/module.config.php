<?php
/**
 * WellCart Platform
 *
 * @copyright  Copyright (c) 2016 WellCart Development Team    http://wellcart.org/
 * @license    http://www.opensource.org/licenses/BSD-3-Clause New BSD License
 */

namespace WellCart\SchemaMigration;

use WellCart\SchemaMigration\Console\PhinxApplication;

return [
    'service_manager' => array(
        'factories' => array(
            PhinxApplication::class => Factory\PhinxApplicationFactory::class,
        ),
    ),
    'controllers'     => [
        'aliases'   => [
            'SchemaMigration::Console' => Controller\ConsoleController::class,
        ],
        'factories' => [
            Controller\ConsoleController::class => Factory\Controller\ConsoleControllerFactory::class,
        ],
    ],
    'route_manager'   => array(
        'factories' => array(
            'wellcart-schema-migration' => Factory\Router\RouteFactory::class,
        ),
    ),
    'console'         => [
        'router' => [
            'routes' => [
                'wellcart-schema-migration' => [
                    'type' => 'wellcart-schema-migration',
                ],
            ],
        ],
    ],
];
