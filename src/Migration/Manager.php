<?php
/**
 * WellCart Platform
 *
 * @copyright  Copyright (c) 2016 WellCart Development Team    http://wellcart.org/
 * @license    http://www.opensource.org/licenses/BSD-3-Clause New BSD License
 */

declare(strict_types = 1);

namespace WellCart\SchemaMigration\Migration;

use Phinx\Migration\Manager as AbstractManager;
use WellCart\ModuleManager\Feature\MigrationsProviderInterface;
use WellCart\SchemaMigration\AbstractMigration;

class Manager extends AbstractManager
{
    /**
     * @var bool
     */
    protected $merged = false;

    /**
     * Sets the database migrations.
     *
     * @param array $migrations Migrations
     *
     * @return Manager
     */
    public function setMigrations(array $migrations)
    {
        $this->migrations = $migrations;
        $this->mergeMigrationsFromModules();
        return $this;
    }

    /**
     * Merge migrations from modules
     *
     * @return array
     */
    protected function mergeMigrationsFromModules()
    {
        if ($this->merged) {
            return $this->migrations;
        }
        if (function_exists('application')
            && $app = application()
        ) {
            $modules = $app->getServiceManager()
                ->get('ModuleManager')
                ->getLoadedModules();

            foreach ($modules as $module) {
                if (!$module instanceof MigrationsProviderInterface) {
                    continue;
                }
                $migrations = (array)$module->getMigrations();
                foreach ($migrations as $id => $migration) {
                    if ($migration instanceof AbstractMigration) {
                        $migration->setVersion($id);
                        $this->migrations[$id] = $migration;
                    }
                }
            }

            ksort($this->migrations);
        }
        $this->merged = true;
        return $this->migrations;
    }
}
