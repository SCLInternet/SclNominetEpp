<?php
/**
 * Contains the nominet Renew request class definition.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */

namespace SclNominetEpp\Request;

use SclNominetEpp\Response\Acknowledge as AcknowledgeResponse;
use SclNominetEpp\Request;

/**
 * This class build the XML for a Nominet EPP fork command.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class Acknowledge extends Request
{
    /**
     * Tells the parent class what the action of this request is.
     */
    public function __construct()
    {
        parent::__construct('poll', new AcknowledgeResponse());
    }

    /**
     * (non-PHPdoc)
     * @see SclNominetEpp\Request.AbstractRequest::addContent()
     */
    protected function addContent(SimpleXMLElement $xml)
    {
       $this->xml->poll->addAttribute('op', 'ack');
    }
}
