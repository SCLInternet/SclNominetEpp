<?php
namespace SclNominetEpp\Request\Update\Field;

use InvalidArgumentException;
use SimpleXMLElement;

/**
 * UpdateDomain "add" and "remove" both use "status" as a field
 */
class DomainNameserver implements UpdateFieldInterface
{
    private $nameserver;

    public function __construct(string $nameserver)
    {
        if (empty($nameserver)) {
            throw new InvalidArgumentException('Nameserver parameter is empty');
        }
        $this->nameserver = $nameserver;
    }

    public function fieldXml(SimpleXMLElement $xml, string $namespace = null)
    {
        $xml->addChild('hostObj', $this->nameserver, $namespace);
    }
}
