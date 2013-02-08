<?php
namespace SclNominetEpp\Request\Update;

/**
 * UpdateDomain "add" and "remove" both use "status" as a field
 * 
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class UpdateHostAddress implements UpdateFieldInterface
{
    public function __construct($address, $version)
    {
        $this->address = $address;
        $this->version  = $version;
    }
    
    public function addFieldXml(\SimpleXMLElement $xml, $namespace) {
        $status = $xml->addChild('addr', $this->address, $namespace);
        $status->addAttribute('ip', $this->version);
    }
}
