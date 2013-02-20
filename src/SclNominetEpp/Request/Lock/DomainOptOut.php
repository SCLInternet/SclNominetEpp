<?php
/**
 * Contains the nominet Renew request class definition.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */

namespace SclNominetEpp\Request;

use SclNominetEpp\Response\DomainOptOut as DomainOptOutResponse;
use SclNominetEpp\Request;

/**
 * This class build the XML for a Nominet EPP lock command.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class DomainOptOut extends Request
{
    
    /**
     * The expiry date.
     *
     * @var string
     */
    protected $domainName;

    /**
     * Tells the parent class what the action of this request is.
     */
    public function __construct()
    {
        parent::__construct('update', new DomainInvestigateResponse());
    }
    
    public function setDomainName($domainName)
    {
        $this->domainName = $domainName;

        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see SclNominetEpp\Request.AbstractRequest::addContent()
     */
    protected function addContent(\SimpleXMLElement $xml)
    {
        $forkNS  = 'http://www.nominet.org.uk/epp/xml/std-locks-1.0';
        $forkXSI = $forkNS . ' std-locks-1.0.xsd';

        //$domainNS  = 'urn:ietf:params:xml:ns:domain-1.0';
        //$domainXSI = 'urn:ietf:params:xml:ns:domain-1.0 domain-1.0.xsd';

        $lock = $xml->addChild('l:lock', '', $forkNS);
        $lock->addAttribute('xsi:schemaLocation', $forkXSI, $forkNS);
        $lock->addAttribute('object', 'domain');   //Can be contact or domain
        $lock->addAttribute('type', 'investigate'); //Can be opt-out or investigate
        $lock->addChild('domainName', $this->domainName);
    }
}
