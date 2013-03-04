<?php
namespace SclNominetEpp\Request\Update\Field;

/**
 * UpdateDomain "add" and "remove" both use "status" as a field
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class HostName implements UpdateFieldInterface
{
    private $nameserver;

    public function __construct($nameserver)
    {
        $this->nameserver = $nameserver;
    }

    public function fieldXml(\SimpleXMLElement $xml, $namespace)
    {
        $xml->addChild('name', $this->nameserver, $namespace);
    }
}
