<?php
/**
 * Contains the nominet CheckContact request class definition.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */

namespace SclNominetEpp\Request;

use SclNominetEpp\Response\CheckContact as CheckContactResponse;

/**
 * This class build the XML for a Nominet EPP contact:check command.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class CheckContact extends AbstractCheck
{
    const TYPE = 'contact';
    const CHECK_NAMESPACE = 'urn:ietf:params:xml:ns:contact-1.0';
    const VALUE_NAME = 'id';

    /**
     * Tells the parent class what the action of this request is.
     */
    public function __construct()
    {
        parent::__construct(
            self::TYPE,
            new CheckContactResponse(),
            self::CHECK_NAMESPACE,
            self::VALUE_NAME
        );
    }
}
