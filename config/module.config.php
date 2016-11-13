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
    'service_manager'  => array(
        'factories' => array(
            PhinxApplication::class => Factory\PhinxApplicationFactory::class,
        ),
    ),
    'controllers'      => [
        'aliases'    => [
            'SchemaMigration::Console' => Controller\ConsoleController::class,
        ],
        'invokables' => [
            Controller\ConsoleController::class => Controller\ConsoleController::class,
        ],
    ],
    'console'          => [
        'router' => [
            'routes' => [
                'wellcart-schema-migration-command' => [
                    'options' => [
                        'route'    => 'wellcart:schema-migration [<c1>] [<c2>] [<c3>] [<c4>] [<c5>] [--help|-h] [--quiet|-q] [--verbose|-v] [--version|-V] [--ansi] [--no-ansi] [--no-interaction|-n] [--configuration|-c] [--xml] [--raw] [--environment|-e] [--target|-t]',
                        'defaults' => [
                            'controller' => 'SchemaMigration::Console',
                            'action'     => 'command'
                        ],
                    ],
                ],
            ],
        ],
    ],
    'schema-migration' => [
        'migrations'   => WELLCART_STORAGE_PATH . 'migrations',
    ],
];
