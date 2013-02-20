<?php
/**
 * Contains the nominet Renew request class definition.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */

namespace SclNominetEpp\Request;

use SclNominetEpp\Response\Fork as ForkResponse;
use SclNominetEpp\Request;

/**
 * This class build the XML for a Nominet EPP fork command.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class Fork extends Request
{
    /**
     * The domain name.
     *
     * @var string
     */
    protected $domain;

    /**
     * The expiry date.
     *
     * @var string
     */
    protected $expDate;

    /**
     * Tells the parent class what the action of this request is.
     */
    public function __construct()
    {
        parent::__construct('update', new ForkResponse());
    }

    public function setDomain($domain, $expDate)
    {
        $this->newContactId = $domain;
        $this->expDate = $expDate;

        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see SclNominetEpp\Request.AbstractRequest::addContent()
     */
    protected function addContent(\SimpleXMLElement $xml)
    {
        $forkNS  = 'http://www.nominet.org.uk/epp/xml/std-fork-1.0';
        $forkXSI = $forkNS . ' std-fork-1.0.xsd';

        $fork = $xml->addChild('f:fork', '', $forkNS);
        $fork->addAttribute('xsi:schemaLocation', $forkXSI, $forkNS);
        $fork->addChild('contactId', $this->contactId);
        $fork->addChild('newContactId', $this->newContactID);
        foreach ($domainNames as $name) {
            $fork->addChild('domainName', $name);
        }
    }
}
