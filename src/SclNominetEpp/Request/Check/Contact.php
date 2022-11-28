<?php
/**
 * Contains the nominet CheckContact request class definition.
 *
 * @author Tom Oram <tom@scl.co.uk>
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */

namespace SclNominetEpp\Request\Check;

use SclNominetEpp\Response\Check\Contact as CheckContactResponse;

/**
 * This class build the XML for a Nominet EPP contact:check command.
 */
class Contact extends AbstractCheck
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
            self::CHECK_NAMESPACE,
            self::VALUE_NAME,
            new CheckContactResponse()
        );
    }

    public function setValues(array $contactIds)
    {
        // @todo
    }
}
