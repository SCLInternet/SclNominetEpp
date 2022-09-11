<?php
namespace SclNominetEpp\Request\Update\Field;

use SimpleXMLElement;

/**
 * UpdateDomain "add" and "remove" both use "status" as a field
 */
class DomainNameserver implements UpdateFieldInterface
{
    private $nameserver;

    public function __construct($nameserver)
    {
        $this->nameserver = $nameserver;
    }

    public function fieldXml(SimpleXMLElement $xml, string $namespace = null)
    {
        $nameservers = $xml->addChild('ns', '', $namespace);
        $nameservers->addChild('hostObj', $this->nameserver, $namespace);
    }
}
