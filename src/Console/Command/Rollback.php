<?php
/**
 * WellCart Platform
 *
 * @copyright  Copyright (c) 2016 WellCart Development Team    http://wellcart.org/
 * @license    http://www.opensource.org/licenses/BSD-3-Clause New BSD License
 */

declare(strict_types = 1);

namespace WellCart\SchemaMigration\Console\Command;

use Phinx\Console\Command\Rollback as AbstractCommand;

class Rollback extends AbstractCommand
{
    use PhinxCommandTrait;
    /**
     * @inheritDoc
     */
    protected function configure()
    {
        parent::configure();
        $this->setName('migration:rollback');
    }
}
