<?php
/**
 * Contains the nominet Renew request class definition.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */

namespace SclNominetEpp\Request\Update;

use SclNominetEpp\Request;
use SclNominetEpp\Response\Update\Fork as ForkResponse;

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
    private $newContactId;
    private $contactId;
    private $domainNames;

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

    public function setValue($hostName)
    {
        // @todo
    }
    
    protected function addContent(\SimpleXMLElement $xml)
    {
        $forkNS  = 'http://www.nominet.org.uk/epp/xml/std-fork-1.0';
        $forkXSI = $forkNS . ' std-fork-1.0.xsd';

        $fork = $xml->addChild('f:fork', '', $forkNS);
        $fork->addAttribute('xsi:schemaLocation', $forkXSI, $forkNS);
        $fork->addChild('contactId', $this->contactId);
        $fork->addChild('newContactId', $this->newContactId);
        foreach ($this->domainNames as $name) {
            $fork->addChild('domainName', $name);
        }
    }
}
