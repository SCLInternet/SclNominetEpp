<?php

namespace SclNominetEpp\Request\Update;

use SclNominetEpp\Request;
use SclNominetEpp\Response\Update\Fork as ForkResponse;
use SimpleXMLElement;

/**
 * This class build the XML for a Nominet EPP fork command.
 */
class Fork extends Request
{
    /**
     * The domain name.
     */
    protected string $domain;

    /**
     * The expiry date.
     */
    protected string $expDate;
    private string $newContactId;
    private string $contactId;
    private array $domainNames;

    /**
     * Tells the parent class what the action of this request is.
     */
    public function __construct()
    {
        parent::__construct('update', new ForkResponse());
    }

    public function setDomain($domain, $expDate): Fork
    {
        $this->newContactId = $domain;
        $this->expDate = $expDate;

        return $this;
    }

    public function setValue(string $hostName)
    {
        $this->domainNames[] = $hostName;
    }

    public function setContactId(string $contactId): void
    {
        $this->contactId = $contactId;
    }

    public function getDomainNames(): array
    {
        return $this->domainNames;
    }

    public function setDomainNames(array $domainNames): void
    {
        $this->domainNames = $domainNames;
    }

    protected function addContent(SimpleXMLElement $action)
    {
        $forkNS  = 'http://www.nominet.org.uk/epp/xml/std-fork-1.0';
        $forkXSI = $forkNS . ' std-fork-1.0.xsd';

        $fork = $action->addChild('f:fork', '', $forkNS);
        $fork->addAttribute('xsi:schemaLocation', $forkXSI, $forkNS);
        $fork->addChild('contactId', $this->contactId);
        $fork->addChild('newContactId', $this->newContactId);
        foreach ($this->domainNames as $name) {
            $fork->addChild('domainName', $name);
        }
    }
}
