<?php

namespace SclNominetEpp\Request\Update\Field;

use SimpleXMLElement;

/**
 * UpdateDomain "add" and "remove" both use "status" as a field
 */
class ContactAddress implements UpdateFieldInterface
{
    private $type;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function fieldXml(SimpleXMLElement $xml, string $namespace = null)
    {
        $postalInfo = $xml->addChild('postalInfo', '', $namespace);
        $postalInfo->addAttribute('type', $this->type);
    }
}
