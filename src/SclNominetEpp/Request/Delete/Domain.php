<?php

namespace SclNominetEpp\Request\Delete;

use SclNominetEpp\Request;
use SimpleXMLElement;
use SclNominetEpp\Response\Delete\Domain as DeleteDomainResponse;
use SclNominetEpp\Domain as DomainObject;

/**
 * This class build the XML for a Nominet EPP delete command.
 */
class Domain extends Request
{
    /**
     * The specific object for deletion
     *
     * @var DomainObject
     */
    private $object;

    /**
     * Tells the parent class what the action of this request is.
     */
    public function __construct()
    {
        parent::__construct('delete', new DeleteDomainResponse());
    }

    /**
     * {@inheritDoc}
     *
     * @param SimpleXMLElement $deleteXML
     */
    public function addContent(SimpleXMLElement $deleteXML)
    {
        $deleteNS  = 'urn:ietf:params:xml:ns:domain-1.0';

        $deleteXSI = $deleteNS . ' ' . "domain-1.0.xsd";

        $delete = $deleteXML->addChild("domain:delete", '', $deleteNS);
        $delete->addAttribute('xsi:schemaLocation', $deleteXSI);
        $delete->addChild('name', $this->getName(), $deleteNS);
    }

    /**
     * Set Domain.
     *
     * @param DomainObject $object
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
