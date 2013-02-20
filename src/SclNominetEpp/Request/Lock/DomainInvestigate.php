<?php
/**
 * Contains the nominet Renew request class definition.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */

namespace SclNominetEpp\Request\Lock;

use SclNominetEpp\Response\Lock\Investigate as InvestigateResponse;
use SclNominetEpp\Request;

/**
 * This class build the XML for a Nominet EPP lock command.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class DomainInvestigate extends Request
{
    
    const OBJECT = 'domain';
    const TYPE   = 'investigation';

    /**
     * Tells the parent class what the action of this request is.
     */
    public function __construct()
    {
        parent::__construct(
            self::OBJECT,
            self::TYPE,
            new InvestigateResponse()
        );
    }
}
