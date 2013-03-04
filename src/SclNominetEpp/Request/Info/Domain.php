<?php

namespace SclNominetEpp\Request\Info;

use SclNominetEpp\Response\Info\Domain as DomainInfoResponse;

/**
 * This class build the XML for a Nominet EPP domain:info command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Domain extends AbstractInfo
{
    const TYPE = 'domain';
    const INFO_NAMESPACE = "urn:ietf:params:xml:ns:domain-1.0";
    const VALUE_NAME = "name";

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(
            self::TYPE,
            self::INFO_NAMESPACE,
            self::VALUE_NAME,
            new DomainInfoResponse()
        );
    }

    /**
     * addContent
     * @todo give this a description
     * @todo Unabstract this specifically for domainInfo.
     *
     * @param SimpleXMLElement $xml
     */
    protected function addContent(\SimpleXMLElement $xml)
    {
        $info = $xml->addChild("{$this->type}:info", '', $this->infoNamespace);

        $name = $info->addChild($this->valueName, $this->value, $this->infoNamespace);
        $name->addAttribute('hosts', 'all');
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
