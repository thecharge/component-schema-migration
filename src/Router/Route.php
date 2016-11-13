<?php
/**
 * WellCart Platform
 *
 * @copyright  Copyright (c) 2016 WellCart Development Team    http://wellcart.org/
 * @license    http://www.opensource.org/licenses/BSD-3-Clause New BSD License
 */

declare(strict_types = 1);

namespace WellCart\SchemaMigration\Router;

use WellCart\SchemaMigration\Console\PhinxApplication;
use Zend\Console\Request as ConsoleRequest;
use Zend\Mvc\Router\Console\RouteInterface;
use Zend\Mvc\Router\RouteMatch;
use Zend\Stdlib\RequestInterface as Request;

class Route implements RouteInterface
{
    /**
     * @var PhinxApplication
     */
    protected $application;

    /**
     * Default values.
     *
     * @var array
     */
    protected $defaults;

    /**
     * Constructor
     *
     * @param PhinxApplication $application
     * @param array            $defaults
     */
    public function __construct(PhinxApplication $application,
        array $defaults = array()
    ) {
        $this->application = $application;
        $this->defaults = $defaults;
    }

    /**
     * Disabled.
     *
     * {@inheritDoc}
     *
     * @throws \BadMethodCallException this method is disabled
     */
    public static function factory($options = array())
    {
        throw new \BadMethodCallException('Unsupported');
    }

    /**
     * {@inheritDoc}
     */
    public function match(Request $request)
    {
        if (!$request instanceof ConsoleRequest) {
            return null;
        }

        $params = $request->getParams()->toArray();
        if (!isset($params[0]) || !$this->application->has($params[0])) {
            return null;
        }
        return new RouteMatch($this->defaults);
    }

    /**
     * Disabled.
     *
     * {@inheritDoc}
     *
     * @throws \BadMethodCallException this method is disabled
     */
    public function assemble(array $params = array(), array $options = array())
    {
        throw new \BadMethodCallException('Unsupported');
    }

    /**
     * {@inheritDoc}
     */
    public function getAssembledParams()
    {
        return array();
    }
}
