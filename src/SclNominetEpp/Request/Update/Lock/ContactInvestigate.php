<?php
/**
 * Contains the nominet Renew request class definition.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */

namespace SclNominetEpp\Request\Update\Lock;

use SclNominetEpp\Response\Update\Lock\Investigate as InvestigateResponse;

/**
 * This class build the XML for a Nominet EPP lock command.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class ContactInvestigate extends AbstractLock
{
    const OBJECT = 'contact';
    const TYPE   = 'investigate';

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
