<?php
namespace SclNominetEpp\Request\Update\Update\Field;

/**
 * UpdateDomain "add" and "remove" both use "status" as a field
 * 
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class ContactAddress implements UpdateFieldInterface
{
    /**
     *
     * @var type 
     */
    private $contact;
    private $type;
    
    /**
     * 
     * @param type $contact
     * @param type $type
     */
    public function __construct($contact, $type)
    {
        $this->contact = $contact;
        $this->type  = $type;
    }
    
    /**
     * 
     * @param SimpleXMLElement $xml
     * @param type $namespace
     */
    public function fieldXml(\SimpleXMLElement $xml, $namespace)
    {
        $postalInfo = $xml->addChild('postalInfo', '', $namespace);
        $postalInfo->addAttribute('type', $this->type);
        
    }
}
