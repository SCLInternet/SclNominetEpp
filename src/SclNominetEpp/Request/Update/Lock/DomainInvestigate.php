<?php
/**
 * Contains the nominet Renew request class definition.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */

namespace SclNominetEpp\Request\Update\Lock;

use SclNominetEpp\Response\Update\Lock\Investigate as InvestigateResponse;
use SclNominetEpp\Request\Update\Lock\AbstractLock;

/**
 * This class provides specific information for the building of the Nominet EPP lock command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class DomainInvestigate extends AbstractLock
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
