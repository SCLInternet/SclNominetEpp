<?php
/**
 * Contains the nominet CheckHost request class definition.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */

namespace SclNominetEpp\Request;

use SclNominetEpp\Response\CheckHost as CheckHostResponse;

/**
 * This class build the XML for a Nominet EPP host:check command.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class CheckHost extends AbstractCheck
{
    const TYPE = 'host';
    const CHECK_NAMESPACE = 'urn:ietf:params:xml:ns:host-1.0';
    const VALUE_NAME = 'name';

    /**
     * Tells the parent class what the action of this request is.
     */
    public function __construct()
    {
        parent::__construct(
            self::TYPE,
            new CheckHostResponse(),
            self::CHECK_NAMESPACE,
            self::VALUE_NAME
        );
    }
}
