<?php

namespace SclNominetEpp\Request\Create;

use SclNominetEpp\Domain as DomainObject;
use SclNominetEpp\Request;
use SimpleXMLElement;
use Exception;

/**
 * This class build the XML for a Nominet EPP domain:create command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Domain extends Request
{

    const TYPE = 'domain';
    const CREATE_NAMESPACE = 'urn:ietf:params:xml:ns:domain-1.0';
    const DUMMY_PASSWORD = 'qwerty';
    const VALUE_NAME = 'name';

    /**
     *
     * @var Domain
     */
    protected $domain = null;

    /**
     *
     * @var string
     */
    protected $value;

    public function __construct()
    {
        parent::__construct('create');
    }

    /**
     *
     * @param  SimpleXMLElement $xml
     * @throws Exception
     */
    public function addContent(SimpleXMLElement $xml)
    {
        if (!$this->domain instanceof DomainObject) {
            $exception = sprintf('A valid Domain object was not passed to Request\Create\Domain, Ln:%d', __LINE__);
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

    /**
     *
     * @param SimpleXMLElement $create
     */
    protected function createNameservers(SimpleXMLElement $create)
    {
        foreach ($this->domain->getNameservers() as $nameserver) {
            $create->addChild('hostObj', $nameserver->getHostName());
        }
    }

    /**
     *
     * @param SimpleXMLElement $create
     */
    protected function createContacts(SimpleXMLElement $create)
    {
        foreach ($this->domain->getContacts() as $type => $value) {
            $contact = $create->addChild('contact', $value->getId());
            $contact->addAttribute('type', $type);
        }
    }

    /**
     *
     * @param Domain $domain
     */
    public function setDomain(DomainObject $domain)
    {
        $this->domain = $domain;
    }
}
