<?php

namespace SclNominetEpp\Request;

use SclNominetEpp\Domain;

use \Exception;

/**
 * This class build the XML for a Nominet EPP domain:create command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class CreateDomain extends Request
{

    const TYPE = 'domain';
    const CREATE_NAMESPACE = 'urn:ietf:params:xml:ns:domain-1.0';
    const DUMMY_PASSWORD = 'qwerty';
    const VALUE_NAME = 'name';

    protected $domain = null;
    protected $value;

    public function __construct()
    {
        parent::__construct('create');
    }


    public function addContent($xml)
    {
        if (!$this->domain instanceof Domain) {
            $exception = sprintf('A valid Domain object was not passed to Request\CreateDomain, Ln:%d', __LINE__);
            throw new Exception($exception);
        }

        //@todo the section below needs to be made domain specific, it's been pasted from CreateContact

        $create = $xml->addChild("domain:create", '', self::CREATE_NAMESPACE);

        $create->addChild(self::VALUE_NAME, $this->domain->getName(), self::CREATE_NAMESPACE);
        $period = $create->addChild('period', 2);
        $period->addAttribute('unit', 'y');

        $ns = $create->addChild('ns');
        $this->createNameservers($ns);

        $create->addChild('registrant', $this->domain->getRegistrant());

        $this->createContacts($create);

        //Mandatory for EPP but not used by nominet
        $authInfo = $create->addChild('authInfo');
        $authInfo->addChild('pw', self::DUMMY_PASSWORD);
    }

    public function createNameservers($create)
    {
        foreach ($this->domain->getNameservers() as $nameserver) {
            $create->addChild('hostObj', $nameserver->getHostName());
        }
    }

    public function createContacts($create)
    {
        foreach ($this->domain->getContacts() as $type => $value) {
            $contact = $create->addChild('contact', $value->getId());
            $contact->addAttribute('type', $type);
        }
    }

    public function setDomain($domain)
    {
        $this->domain = $domain;
    }
}
