<?php
/**
 * WellCart Platform
 *
 * @copyright  Copyright (c) 2016 WellCart Development Team    http://wellcart.org/
 * @license    http://www.opensource.org/licenses/BSD-3-Clause New BSD License
 */

declare(strict_types = 1);

namespace WellCart\SchemaMigration;

use Phinx\Migration\AbstractMigration as Migration;
use WellCart\SchemaMigration\Db\Table;

abstract class AbstractMigration extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function table($tableName, $options = [])
    {
        return new Table($tableName, $options, $this->getAdapter());
    }
}
