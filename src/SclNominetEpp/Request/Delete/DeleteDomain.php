<?php

namespace SclNominetEpp\Request\Delete;

use SclNominetEpp\Request;
use SimpleXMLElement;
use SclNominetEpp\Response\Delete\Domain as DeleteDomainResponse;

/**
 * This class build the XML for a Nominet EPP delete command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
abstract class DeleteDomain extends Request
{
    /**
     * The value of the specific object for deletion
     *
     * @var string
     */
    private $value;

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
