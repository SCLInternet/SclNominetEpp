<?php
namespace SclNominetEpp\Request\Update\Field;

use SimpleXMLElement;

/**
 * UpdateDomain "add" and "remove" both use "status" as a field
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

    public function fieldXml(SimpleXMLElement $xml, string $namespace = null)
    {
        $status = $xml->addChild('status', $this->message, $namespace);
        $status->addAttribute('s', $this->status);
        $status->addAttribute('lang', 'en');
    }
}
