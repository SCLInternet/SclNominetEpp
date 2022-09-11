<?php
namespace SclNominetEpp\Request\Update\Field;

use SclNominetEpp\Contact;
use SimpleXMLElement;

/**
 * UpdateDomain "add" and "remove" both use "status" as a field
 */
class DomainRegistrant implements UpdateFieldInterface
{
    private $registrant;
    private $passwd;

    public function __construct(?string $registrant, ?string $passwd)
    {
        $this->registrant = $registrant;
        $this->passwd  = $passwd;
    }

    public function fieldXml(SimpleXMLElement $xml, string $namespace = null)
    {
        if ($this->registrant) {
            $xml->addChild('registrant', $this->registrant, $namespace);
        }
        if ($this->passwd) {
            $authInfo = $xml->addChild('authInfo');
            $authInfo->addAttribute('pw', $this->passwd);
        }
    }
}
