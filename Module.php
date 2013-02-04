<?php
/**
 * This module contains a set of tools for accessing the Nominet EPP management
 * system.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */

namespace SclNominetEpp;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

/**
 * Sets up the module configurations.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class Module implements
    ConfigProviderInterface,
    AutoloaderProviderInterface,
    ServiceProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * @return array
     */
    public function getServiceConfig()
    {
        return array(
            'shared' => array(
                'SclNominetEpp\Socket' => false,
            ),
            'invokables' => array(
                'SclNominetEpp\Socket'      => 'BasicSocket\Socket',
            ),
            'factories' => array(
                'SclNominetEpp\Nominet'      => 'SclNominetEpp\Service\NominetFactory',
                'SclNominetEpp\Communicator' => 'SclNominetEpp\Service\CommunicatorFactory',
            ),
        );
    }
}
