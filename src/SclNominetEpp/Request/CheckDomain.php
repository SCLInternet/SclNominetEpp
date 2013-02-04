<?php
/**
 * Contains the nominet CheckDomain request class definition.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */

namespace SclNominetEpp\Request;

use SclNominetEpp\Response\CheckDomain as CheckDomainResponse;

/**
 * This class build the XML for a Nominet EPP domain:check command.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class CheckDomain extends AbstractCheck
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
