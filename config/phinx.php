<?php
/**
 * WellCart Platform
 *
 * @copyright  Copyright (c) 2016 WellCart Development Team    http://wellcart.org/
 * @license    http://www.opensource.org/licenses/BSD-3-Clause New BSD License
 */

$files = [
    WELLCART_ROOT . 'config/autoload/db.global.php',
    __DIR__ . '/../tests/config/autoload/db.global.php.dist',
];

$found = false;
foreach ($files as $file) {
    if (file_exists($file)) {
        $dbConfigFile = $file;
        $found = true;
        break;
    }
}


if (!$found) {
    return [];
}

$dbConfigFile = include $dbConfigFile;
if (!empty($dbConfigFile['db']['adapters']['Zend\Db\Adapter\Adapter'])) {
    $dbConfig = $dbConfigFile['db']['adapters']['Zend\Db\Adapter\Adapter'];
} else {
    $dbConfig = $dbConfigFile['db'];
}

return [
    'paths'        => [
        'migrations' => WELLCART_STORAGE_PATH . 'db' . DS . 'migrations' . DS,
        'seeds'      => WELLCART_STORAGE_PATH . 'db' . DS . 'seeds' . DS,
    ],
    'environments' =>
        [
            'default_migration_table' => 'setup_schema_migration',
            'default_database'        => 'wellcart',
            'wellcart'                => [
                'adapter'      => ($dbConfig['driver'] != 'pdo_mysql') ? 'pgsql'
                    : 'mysql',
                'host'         => (!empty($dbConfig['host']))
                    ? $dbConfig['host']
                    : 'localhost',
                'name'         => $dbConfig['database'],
                'user'         => $dbConfig['username'],
                'pass'         => (!empty($dbConfig['password']))
                    ? $dbConfig['password'] : '',
                'port'         => (!empty($dbConfig['port']))
                    ? $dbConfig['port']
                    : 3306,
                'charset'      => 'utf8',
                'table_prefix' => (!empty($dbConfig['table_prefix']))
                    ? $dbConfig['table_prefix'] : null,
            ],
        ],
];
