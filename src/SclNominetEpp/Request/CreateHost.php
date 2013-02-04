<?php

namespace SclNominetEpp\Request;

use SclNominetEpp\Nameserver;

/**
 * This class build the XML for a Nominet EPP host:create command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class CreateHost extends Request
{
    const TYPE = 'host';
    const CREATE_NAMESPACE = 'urn:ietf:params:xml:ns:host-1.0';
    const VALUE_NAME = 'name';

    protected $nameserver;
    protected $value;

    public function __construct()
    {
        parent::__construct('create');
    }
    
    /**
     * 
     * @param SimpleXMLElement $xml
     * @throws Exception
     */
    public function addContent($xml)
    {
        $host = $this->nameserver;

        if (!$host instanceof Nameserver) {
            $exception = sprintf('A valid Nameserver object was not passed to \Request\CreateHost, Ln:%d', __LINE__);
            throw new Exception($exception);
        }

        $create = $xml->addChild("host:create", '', self::CREATE_NAMESPACE);

        $create->addChild(self::VALUE_NAME, $host->getHostName(), self::CREATE_NAMESPACE);

        if ($host->getIpv4() !== null) {
            $ipv4 = $create->addChild('addr', $host->getIpv4());
            $ipv4->addAttribute('ip', 'v4');
        }
        if ($host->getIpv6() !== null) {
            $ipv6 = $create->addChild('addr', $host->getIpv6());
            $ipv6->addAttribute('ip', 'v6');
        }
    }
    
    /**
     * 
     * @param Nameserver $nameserver
     */
    public function setNameserver(Nameserver $nameserver){
        $this->nameserver = $nameserver;
    }
}
