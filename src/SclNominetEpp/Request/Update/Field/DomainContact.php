<?php
namespace SclNominetEpp\Request\Update\Field;

/**
 * UpdateDomain "add" and "remove" both use "status" as a field
 * 
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class DomainContact implements UpdateFieldInterface
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
        $contact = $xml->addChild('contact', $this->contact, $namespace);
        $contact->addAttribute('type', $this->type);
    }
}
