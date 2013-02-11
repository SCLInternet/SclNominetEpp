<?php
namespace SclNominetEpp\Request\Update\Field;

/**
 * UpdateDomain "add" and "remove" both use "status" as a field
 * 
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class UpdateDomainNameserver implements UpdateFieldInterface
{
    private $contact;
    private $type;
    
    public function __construct($nameserver)
    {
        $this->nameserver = $nameserver;
    }
    
    public function fieldXml(\SimpleXMLElement $xml, $namespace)
    {
        $nameserver = $xml->addChild('ns', '', $namespace);
        $nameserver->addChild('hostObj', $this->nameserver);
    }
}
