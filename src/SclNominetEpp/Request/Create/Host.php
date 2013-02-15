<?php

namespace SclNominetEpp\Request\Create;

use SclNominetEpp\Nameserver;

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

    protected $nameserver;
    protected $value;

    public function __construct()
    {
        $this->value = $this->nameserver->getHostName();
        parent::__construct(
            self::TYPE,
            self::CREATE_NAMESPACE,
            self::VALUE_NAME,
            $this->value,
            new CheckContactResponse()
        );
    }
    
    public function addSpecificContent($create)
    {
        if ($this->nameserver->getIpv4() !== null) {
            $ipv4 = $create->addChild('addr', $this->nameserver->getIpv4());
            $ipv4->addAttribute('ip', 'v4');
        }
        if ($this->nameserver->getIpv6() !== null) {
            $ipv6 = $create->addChild('addr', $this->nameserver->getIpv6());
            $ipv6->addAttribute('ip', 'v6');
        }
    }
    
    public function objectValidate()
    {
        if (!$this->nameserver instanceof Nameserver) {
            $exception = sprintf('A valid Nameserver object was not passed to \Request\CreateHost, Ln:%d', __LINE__);
            throw new Exception($exception);
        }
    }
    
    /**
     *
     * @param Nameserver $nameserver
     */
    public function setNameserver(Nameserver $nameserver)
    {
        $this->nameserver = $nameserver;
    }
}
