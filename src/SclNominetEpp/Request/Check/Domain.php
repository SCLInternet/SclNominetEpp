<?php
/**
 * Contains the nominet CheckDomain request class definition.
 *
 * @author Tom Oram <tom@scl.co.uk>
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */

namespace SclNominetEpp\Request\Check;

use SclNominetEpp\Response\Check\Domain as CheckDomainResponse;

/**
 * This class build the XML for a Nominet EPP domain:check command.
 *
 * @author Tom Oram <tom@scl.co.uk>
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Domain extends AbstractCheck
{
    const TYPE = 'domain';
    const CHECK_NAMESPACE = 'urn:ietf:params:xml:ns:domain-1.0';
    const VALUE_NAME = 'name';

    /**
     * Tells the parent class what the action of this request is.
     */
    public function __construct()
    {
        parent::__construct(
            self::TYPE,
            new CheckDomainResponse(),
            self::CHECK_NAMESPACE,
            self::VALUE_NAME
        );
    }
}
