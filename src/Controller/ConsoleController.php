<?php
/**
 * WellCart Platform
 *
 * @copyright  Copyright (c) 2016 WellCart Development Team    http://wellcart.org/
 * @license    http://www.opensource.org/licenses/BSD-3-Clause New BSD License
 */

declare(strict_types = 1);

namespace WellCart\SchemaMigration\Controller;

use WellCart\SchemaMigration\Manager\PhinxManager;
use Zend\Console\Request as ConsoleRequest;
use Zend\Mvc\Controller\AbstractActionController;

class ConsoleController extends AbstractActionController
{
    /**
     * @var PhinxManager
     */
    protected $manager;

    /**
     * Display phinx help text
     *
     * @return String
     * @throws RuntimeException
     */
    public function commandAction()
    {
        /**
         * Enforce valid console request
         */
        $request = $this->getRequest();
        if (!$request instanceof ConsoleRequest) {
            throw new \RuntimeException(
                'You can only use this action from a console!'
            );
        }

        /**
         * Run the custom command
         */
        return $this->getPhinxManager()->command();
    }

    /**
     * Returns the PhinxManager class
     *
     * @return PhinxManager
     */
    protected function getPhinxManager()
    {
        if (!$this->manager) {
            $this->manager = new PhinxManager(
                $this->getServiceLocator()->get('console'),
                $this->getServiceLocator()->get('config')
            );
        }

        return $this->manager;
    }
}
