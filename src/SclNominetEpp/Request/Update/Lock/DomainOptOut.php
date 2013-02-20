<?php
/**
 * Contains the nominet Renew request class definition.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */

namespace SclNominetEpp\Request\Update\Lock;

use SclNominetEpp\Response\Update\Lock\OptOut as OptOutResponse;
use SclNominetEpp\Request\Update\Lock\AbstractLock;

/**
 * This class provides specific information for the building of the Nominet EPP lock command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class DomainOptOut extends AbstractLock
{  
    const OBJECT = 'domain';
    const TYPE   = 'opt-out';

    /**
     * Tells the parent class what the action of this request is.
     */
    public function __construct()
    {
        parent::__construct(
            self::OBJECT,
            self::TYPE,
            new OptOutResponse()
        );
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
        $lock->addAttribute('type', 'opt-out'); //Can be opt-out or investigate
        $lock->addChild('domainName', $this->domainName);
    }
}
