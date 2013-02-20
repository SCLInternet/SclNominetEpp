<?php
namespace SclNominetEpp\Request\Update\Update\Field;

/**
 * UpdateDomain "add" and "remove" both use "status" as a field
 * 
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class DomainRegistrant implements UpdateFieldInterface
{
    private $contact;
    private $passwd;
    
    public function __construct($contact, $passwd)
    {
        $this->contact = $contact;
        $this->passwd  = $passwd;
    }
    
    public function fieldXml(\SimpleXMLElement $xml, $namespace)
    {
        $xml->addChild('registrant', $this->contact, $namespace);
        $authInfo   = $xml->addChild('authInfo');
        $authInfo->addAttribute('pw', $this->passwd);
    }
}
