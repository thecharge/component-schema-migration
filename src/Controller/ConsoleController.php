<?php
/**
 * WellCart Platform
 *
 * @copyright  Copyright (c) 2016 WellCart Development Team    http://wellcart.org/
 * @license    http://www.opensource.org/licenses/BSD-3-Clause New BSD License
 */

declare(strict_types = 1);

namespace WellCart\SchemaMigration\Controller;

use DoctrineModule\Component\Console\Input\RequestInput;
use WellCart\Mvc\Controller\AbstractActionController;
use WellCart\SchemaMigration\Console\PhinxApplication;

class ConsoleController extends AbstractActionController
{
    /**
     * @var \Symfony\Component\Console\Application
     */
    protected $application;

    /**
     * Constructor.
     *
     * @param PhinxApplication $application
     */
    public function __construct(PhinxApplication $application)
    {
        $this->application = $application;
    }

    /**
     * Index action - runs the console application
     */
    public function handleAction()
    {
        $exitCode = $this->application->run(new RequestInput($this->getRequest()));
        if (is_numeric($exitCode)) {
            $model = $this->createConsoleModel();
            $model->setErrorLevel($exitCode);
            return $model;
        }
    }
}
