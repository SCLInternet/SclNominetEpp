<?php
/**
 * Contains the nominet List request class definition.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */

namespace SclNominetEpp\Request;

use SclNominetEpp\Response\ListDomains as ListDomainsResponse;

use SclNominetEpp\Request;

/**
 * This class build the XML for a Nominet EPP list command.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class ListDomains extends Request
{

    /**
     * The month of the list element (also contains the year).
     *
     * @var int
     */
    protected $month;

    /**
     * Tells the parent class what the action of this request is.
     */
    public function __construct()
    {
        parent::__construct('info', new ListDomainsResponse());
    }

    public function setDate($month, $year)
    {
        $this->month = $year . '-' . $month;

        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see SclNominetEpp\Request.AbstractRequest::addContent()
     */
    protected function addContent(\SimpleXMLElement $xml)
    {

        $lNS     = 'http://www.nominet.org.uk/epp/xml/std-list-1.0';

        $listXSI = $lNS . ' std-list-1.0.xsd';

        $domainList = $xml->addChild('l:list', '', $lNS);

        $domainList->addAttribute('xsi:schemaLocation', $listXSI, self::XSI_NAMESPACE);

        $domainList->addChild('month', $this->month);
    }
}
