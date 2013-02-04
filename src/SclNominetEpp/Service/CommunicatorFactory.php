<?php
namespace SclNominetEpp\Service;

use SclNominetEpp\Communicator;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @author Tom Oram
 */
class CommunicatorFactory implements FactoryInterface
{

    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Configuration');
        $config = $config['nominet_epp'];

        if ($config['live']) {
            if ($config['secure']) {
                $connection = $config['config']['live']['secure'];
            } else {
                $connection = $config['config']['live']['insecure'];
            }
        } else {
            if ($config['secure']) {
                $connection = $config['config']['test']['secure'];
            } else {
                $connection = $config['config']['test']['insecure'];
            }
        }

        $communicator = new Communicator(
            $serviceLocator->get('SclNominetEpp\Socket')
        );

        $communicator->connect(
            $connection['host'],
            $connection['port'],
            $config['secure']
        );

        return $communicator;
    }
}
