<?php
namespace SclNominetEpp\Request\Update\Field;

use InvalidArgumentException;
use SimpleXMLElement;

/**
 * UpdateDomain "add" and "remove" both use "status" as a field
 */
class DomainNameserver implements UpdateFieldInterface
{
    private string $nameserver;

    public function __construct(string $nameserver)
    {
        if (empty($nameserver)) {
            throw new InvalidArgumentException('Nameserver parameter is empty');
        }
        $this->nameserver = $nameserver;
    }

    public function fieldXml(SimpleXMLElement $xml, string $namespace = null)
    {
        /**
         * "A <domain:hostObj> element contains the fully qualified name of a known name server host object."
         * @see https://www.rfc-editor.org/rfc/rfc5731#section-1.1
         */
        $hostName = rtrim($this->nameserver, '.');
        $xml->addChild('hostObj', $hostName, $namespace);
    }
}
