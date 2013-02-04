<?php

namespace SclNominetEpp\Request;

use SclNominetEpp\Response\DomainInfo as DomainInfoResponse;

/**
 * This class build the XML for a Nominet EPP domain:info command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class DomainInfo extends AbstractInfo
{
    const TYPE = 'domain';
    const INFO_NAMESPACE = "urn:ietf:params:xml:ns:domain-1.0";
    const VALUE_NAME = "name";

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
     * (non-PHPdoc)
     * @see SclNominetEpp\Request.AbstractRequest::addContent()
     * @todo Unabstract this specifically for domainInfo.
     */
    protected function addContent($xml)
    {
        $info = $xml->addChild("{$this->type}:info", '', $this->infoNamespace);

        $name = $info->addChild($this->valueName, $this->value, $this->infoNamespace);
        $name->addAttribute('hosts', 'all');
    }
}
