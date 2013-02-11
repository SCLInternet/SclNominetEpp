<?php
namespace SclNominetEpp\Request\Update\Field;

/**
 * UpdateDomain "add" and "remove" both use "status" as a field
 * 
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Status implements UpdateFieldInterface
{
    private $message;
    private $status;
    
    public function __construct($message, $status)
    {
        $this->message = $message;
        $this->status  = $status;
    }
    
    public function fieldXml(\SimpleXMLElement $xml, $namespace)
    {
        $status = $xml->addChild('status', $this->message, $namespace);
        $status->addAttribute('s', $this->status);
    }
}
