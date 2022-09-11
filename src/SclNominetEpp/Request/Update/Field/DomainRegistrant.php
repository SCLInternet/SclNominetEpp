<?php
namespace SclNominetEpp\Request\Update\Field;

use SclNominetEpp\Contact;
use SimpleXMLElement;

/**
 * UpdateDomain "add" and "remove" both use "status" as a field
 */
class DomainRegistrant implements UpdateFieldInterface
{
    /** @var Contact */
    private $contact;
    private $passwd;

    public function __construct($contact, $passwd)
    {
        $this->contact = $contact;
        $this->passwd  = $passwd;
    }

    public function fieldXml(SimpleXMLElement $xml, string $namespace = null)
    {
        if ($this->contact) {
            $xml->addChild('registrant', $this->contact->getId(), $namespace);
        }
        if ($this->passwd) {
            $authInfo = $xml->addChild('authInfo');
            $authInfo->addAttribute('pw', $this->passwd);
        }
    }
}
