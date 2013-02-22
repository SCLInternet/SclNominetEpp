<?php
/**
 * Contains the nominet Lock Contact Investigate request class definition.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */

namespace SclNominetEpp\Request\Update\Lock;

use SclNominetEpp\Response\Update\Lock\Investigate as InvestigateResponse;
use SclNominetEpp\Request\Update\Lock\AbstractLock;

/**
 * This class provides specific information for the building of the Nominet EPP lock command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class ContactInvestigate extends AbstractLock
{
    const OBJECT = 'contact';
    const TYPE   = 'investigate';

    /**
     * Tells the abstract class the expected response, object and type.
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
