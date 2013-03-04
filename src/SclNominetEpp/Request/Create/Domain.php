<?php

namespace SclNominetEpp\Request\Create;

use SclNominetEpp\Domain as DomainObject;
use SclNominetEpp\Response\Create\Domain as CreateDomainResponse;
use SimpleXMLElement;
use Exception;

/**
 * This class build the XML for a Nominet EPP domain:create command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Domain extends AbstractCreate
{

    const TYPE = 'domain';
    const CREATE_NAMESPACE = 'urn:ietf:params:xml:ns:domain-1.0';
    const DUMMY_PASSWORD = 'qwerty';
    const VALUE_NAME = 'name';

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(
            self::TYPE,
            self::CREATE_NAMESPACE,
            self::VALUE_NAME,
            new CreateDomainResponse()
        );
    }

    /**
     * includes Create Object specific content for addContent in AbstractCreate
     *
     * @param SimpleXMLElement $create
     */
    protected function addSpecificContent(SimpleXMLElement $create)
    {
        $period = $create->addChild('period', 2);
        $period->addAttribute('unit', 'y');

        $ns = $create->addChild('ns');
        $this->createNameservers($ns);

        $create->addChild('registrant', $this->object->getRegistrant());

        $this->createContacts($create);

        //Mandatory for EPP but not used by nominet
        $authInfo = $create->addChild('authInfo');
        $authInfo->addChild('pw', self::DUMMY_PASSWORD);
    }

    /**
     * Creates XML for all the nameservers
     *
     * @param SimpleXMLElement $ns
     */
    protected function createNameservers(SimpleXMLElement $ns)
    {
        foreach ($this->object->getNameservers() as $nameserver) {
            $ns->addChild('hostObj', $nameserver->getHostName());
        }
    }

    /**
     * Creates XML for all the contacts
     *
     * @param SimpleXMLElement $create
     */
    protected function createContacts(SimpleXMLElement $create)
    {
        foreach ($this->object->getContacts() as $contact) {
            $contactXml = $create->addChild('contact', $contact->getId());
            $contactXml->addAttribute('type', $contact->getType());
        }
    }

    /**
     * An Exception is thrown if the object is not of type \SclNominetEpp\Domain
     *
     * @param \SclNominetEpp\Domain $object
     * @return boolean
     * @throws Exception
     */
    public function objectValidate($object)
    {
        if (!$object instanceof DomainObject) {
            $exception = sprintf('A valid Domain object was not passed to Request\Create\Domain, Ln:%d', __LINE__);
            throw new Exception($exception);
        }
        return true;
    }

    /**
     * Set Domain.
     *
     * @param \SclNominetEpp\Domain $object
     */
    public function setDomain(DomainObject $object)
    {
        $this->object = $object;
    }

    protected function getName()
    {
        return $this->object->getName();
    }
}
