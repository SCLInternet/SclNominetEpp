<?php
/**
 * Contains the nominet Renew request class definition.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */

namespace SclNominetEpp\Request;

use SclNominetEpp\Response\Renew as RenewResponse;
use SclNominetEpp\Request;

/**
 * This class build the XML for a Nominet EPP renew command.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class Renew extends Request
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
        parent::__construct('renew', new RenewResponse());
    }

    /**
     * Set the date
     *
     * @param string $domain
     * @param DateTime $expDate
     * @return \SclNominetEpp\Request\Renew
     */
    public function setDomain($domain, $expDate)
    {
        $this->domain = $domain;
        $this->expDate = $expDate;

        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see SclNominetEpp\Request.AbstractRequest::addContent()
     *
     * @param SimpleXMLElement $xml
     */
    protected function addContent(SimpleXMLElement $xml)
    {
        $domainNS  = 'urn:ietf:params:xml:ns:domain-1.0';
        $domainXSI = $domainNS . ' domain-1.0.xsd';

        //$domainNS  = 'urn:ietf:params:xml:ns:domain-1.0';
        //$domainXSI = 'urn:ietf:params:xml:ns:domain-1.0 domain-1.0.xsd';

        $domainRenew = $xml->addChild('domain:renew', '', $domainNS);
        $domainRenew->addAttribute('xsi:schemaLocation', $domainXSI, self::XSI_NAMESPACE);
        $domainRenew->addChild('name', $this->domain);
        $domainRenew->addChild('curExpDate', $this->expDate);
        $period = $domainRenew->addChild('period', 2);
        $period->addAttribute('unit', 'y');

    }
}
