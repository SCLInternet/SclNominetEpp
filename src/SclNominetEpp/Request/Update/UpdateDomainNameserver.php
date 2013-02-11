<?php
namespace SclNominetEpp\Request\Update;

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
    
    public function addFieldXml(\SimpleXMLElement $xml, $namespace)
    {
        $nameserver = $xml->addChild('ns', '', $namespace);
        $nameserver->addChild('hostObj', $this->nameserver);
    }
    
    public function removeFieldXml(\SimpleXMLElement $xml, $namespace) {
        $nameserver = $xml->addChild('ns', '', $namespace);
        $nameserver->addChild('hostObj', $this->nameserver);
    }
}
