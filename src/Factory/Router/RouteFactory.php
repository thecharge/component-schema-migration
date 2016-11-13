<?php
/**
 * WellCart Platform
 *
 * @copyright  Copyright (c) 2016 WellCart Development Team    http://wellcart.org/
 * @license    http://www.opensource.org/licenses/BSD-3-Clause New BSD License
 */

declare(strict_types = 1);

namespace WellCart\SchemaMigration\Factory\Router;

use Interop\Container\ContainerInterface;
use WellCart\SchemaMigration\Console\PhinxApplication;
use WellCart\SchemaMigration\Router\Route;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RouteFactory  implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): Route
    {
        $application = $container
            ->get(PhinxApplication::class);
        return new Route(
            $application,
            array(
                'controller' => 'SchemaMigration::Console',
                'action'     => 'handle'
            )
        );
    }

    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return $this($serviceLocator->getServiceLocator(), Route::class);
    }
}
