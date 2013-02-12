<?php
namespace SclNominetEpp\Request\Update\Field;

/**
 * UpdateDomain "add" and "remove" both use "status" as a field
 * 
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class ContactAddress implements UpdateFieldInterface
{
    private $contact;
    private $type;
    
    public function __construct($contact, $type)
    {
        $this->contact = $contact;
        $this->type  = $type;
    }
    
    public function fieldXml(\SimpleXMLElement $xml, $namespace)
    {
        $postalInfo = $xml->addChild('postalInfo', '', $namespace);
        $postalInfo->addAttribute('type', $this->type);
        
    }
}
