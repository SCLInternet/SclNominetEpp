<?php

namespace SclNominetEpp\Request\Create;

use SclNominetEpp\Response\Create\Host as CreateHostResponse;
use SclNominetEpp\Nameserver;
use SimpleXMLElement;
use Exception;

/**
 * This class build the XML for a Nominet EPP host:create command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Host extends AbstractCreate
{
    const TYPE = 'host';
    const CREATE_NAMESPACE = 'urn:ietf:params:xml:ns:host-1.0';
    const VALUE_NAME = 'name';

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(
            self::TYPE,
            self::CREATE_NAMESPACE,
            self::VALUE_NAME,
            new CreateHostResponse()
        );
    }

    /**
     * This function is used to add Object specific content
     * to the Abstract class' implementation of addContent
     *
     * @param SimpleXMLElement $create
     */
    protected function addSpecificContent(SimpleXMLElement $create)
    {
        if ($this->object->getIpv4() !== null) {
            $ipv4 = $create->addChild('addr', $this->object->getIpv4());
            $ipv4->addAttribute('ip', 'v4');
        }
        if ($this->object->getIpv6() !== null) {
            $ipv6 = $create->addChild('addr', $this->object->getIpv6());
            $ipv6->addAttribute('ip', 'v6');
        }
    }

    /**
     * An Exception is thrown if the object is not of type \SclNominetEpp\Contact
     *
     * @throws Exception
     */
    public function objectValidate($object)
    {
        if (!$object instanceof Nameserver) {
            $exception = sprintf('A valid Nameserver object was not passed to \Request\CreateHost, Ln:%d', __LINE__);
            throw new Exception($exception);
        }
        return true;
    }


    /**
     *
     * @param Nameserver $nameserver
     */
    public function setNameserver(Nameserver $object)
    {
        $this->object = $object;
    }


    protected function getName()
    {
        return $this->object->getHostName();
    }
}
