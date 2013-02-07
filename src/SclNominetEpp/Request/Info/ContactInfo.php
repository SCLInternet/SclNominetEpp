<?php

namespace SclNominetEpp\Request;

use SclNominetEpp\Response\ContactInfo as ContactInfoResponse;

/**
 * Page-Level DocBlock
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */

/**
 * This class build the XML for a Nominet EPP contact:info command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class ContactInfo extends AbstractInfo
{
    const TYPE = 'contact';
    const INFO_NAMESPACE = "urn:ietf:params:xml:ns:contact-1.0";
    const VALUE_NAME = "id";

    public function __construct()
    {
        parent::__construct(
            self::TYPE,
            self::INFO_NAMESPACE,
            self::VALUE_NAME,
            new ContactInfoResponse()
        );
    }
}
