<?php
/**
 * Contains the NominetFactory class definition.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */

namespace SclNominetEpp\Service;

use SclNominetEpp\Nominet;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * This factory constructs and instance of the Nominet class and logs it in.
 *
 * @author Tom Oram
 */
class NominetFactory implements FactoryInterface
{
    /**
     * (non-PHPdoc)
     * @see Zend\ServiceManager.FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options = $serviceLocator->get('Configuration');

        if (!isset($options['nominet_epp'])) {
            throw new \Exception('No Nominet EPP configuration specified.');
        }

        $options = $options['nominet_epp'];

        if (!isset($options['tag'])) {
            throw new \Exception('Tag not specified in the configuration.');
        }

        if (!isset($options['password'])) {
            throw new \Exception('Password not specified in the configuration.');
        }

        $nominet = new Nominet();

        $nominet->setServiceLocator($serviceLocator);

        if (!$nominet->login($options['tag'], $options['password'])) {
            $response = $nominet->getResponse();

            throw new \RuntimeException(
                'Nominet login failed: ' . $response->message(),
                $response->code()
            );
        }

        return $nominet;
    }
}
