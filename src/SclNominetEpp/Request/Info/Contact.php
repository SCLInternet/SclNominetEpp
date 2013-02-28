<?php

namespace SclNominetEpp\Request\Info;

use SclNominetEpp\Response\Info\Contact as ContactInfoResponse;

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
class Contact extends AbstractInfo
{
    const TYPE = 'contact';
    const INFO_NAMESPACE = "urn:ietf:params:xml:ns:contact-1.0";
    const VALUE_NAME = "id";

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(
            self::TYPE,
            self::INFO_NAMESPACE,
            self::VALUE_NAME,
            new ContactInfoResponse()
        );
    }

    protected function getName()
    {
        return $this->object->getId();
    }
}
