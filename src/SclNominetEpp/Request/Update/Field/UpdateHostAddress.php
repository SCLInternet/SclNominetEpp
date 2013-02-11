<?php
namespace SclNominetEpp\Request\Update\Field;

/**
 * UpdateDomain "add" and "remove" both use "status" as a field
 * 
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class UpdateHostAddress implements UpdateFieldInterface
{
    private $address;
    private $version;
    
    public function __construct($address, $version)
    {
        $this->address = $address;
        $this->version  = $version;
    }
    
    public function fieldXml(\SimpleXMLElement $xml, $namespace)
    {
        $address = $xml->addChild('addr', $this->address, $namespace);
        $address->addAttribute('ip', $this->version);
    }
}
