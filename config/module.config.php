<?php
/**
 * WellCart Platform
 *
 * @copyright  Copyright (c) 2016 WellCart Development Team    http://wellcart.org/
 * @license    http://www.opensource.org/licenses/BSD-3-Clause New BSD License
 */

return [
    'controllers'      => [
        'invokables' => [
            'WellCart\SchemaMigration\Controller\Console' => 'WellCart\SchemaMigration\Controller\ConsoleController',
        ],
    ],
    'console'          => [
        'router' => [
            'routes' => [
                'wellcart-schema-migration-command' => [
                    'options' => [
                        'route'    => 'wellcart:schema-migration [<c1>] [<c2>] [<c3>] [<c4>] [<c5>] [--help|-h] [--quiet|-q] [--verbose|-v] [--version|-V] [--ansi] [--no-ansi] [--no-interaction|-n] [--configuration|-c] [--xml] [--raw] [--environment|-e] [--target|-t]',
                        'defaults' => [
                            'controller' => 'WellCart\SchemaMigration\Controller\Console',
                            'action'     => 'command'
                        ],
                    ],
                ],
            ],
        ],
    ],
    'schema-migration' => [
        'zf2-config'   => WELLCART_ROOT . 'config/autoload/db.global.php',
        'phinx-config' => __DIR__ . '/phinx.php',
        'migrations'   => WELLCART_STORAGE_PATH . 'migrations',
    ],
];
