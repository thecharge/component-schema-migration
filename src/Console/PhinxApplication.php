<?php
/**
 * WellCart Platform
 *
 * @copyright  Copyright (c) 2016 WellCart Development Team    http://wellcart.org/
 * @license    http://www.opensource.org/licenses/BSD-3-Clause New BSD License
 */

declare(strict_types = 1);

namespace WellCart\SchemaMigration\Console;

use Phinx\Console\PhinxApplication as AbstractApplication;
use WellCart\SchemaMigration\Console\Command;

class PhinxApplication extends AbstractApplication
{
    /**
     * Object Constructor.
     *
     * Initialize the Phinx console application.
     *
     * @param string $version The Application Version
     */
    public function __construct($version)
    {
        parent::__construct(
            $version
        );

        if (!function_exists('application')) {
            $this->add(new Command\Init());
        }
        $this->addCommands(
            array(
                new Command\Create(),
                new Command\Migrate(),
                new Command\Rollback(),
                new Command\Status(),
                new Command\Breakpoint(),
                new Command\Test(),
                new Command\SeedCreate(),
                new Command\SeedRun(),
            )
        );
    }
}
