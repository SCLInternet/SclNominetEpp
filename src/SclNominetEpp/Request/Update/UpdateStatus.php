<?php
namespace SclNominetEpp\Request\Update;

/**
 * UpdateDomain "add" and "remove" both use "status" as a field
 * 
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class UpdateStatus implements UpdateFieldInterface
{
    private $message;
    private $status;
    
    public function __construct($message, $status)
    {
        $this->message = $message;
        $this->status  = $status;
    }
    
    public function addFieldXml(\SimpleXMLElement $xml, $namespace) {
        $status = $xml->addChild('status', $this->message, $namespace);
        $status->addAttribute('s', $this->status);
    }
}
