<?php

namespace SclNominetEpp\Request\Delete;

use SclNominetEpp\Response\Delete\Contact as DeleteContactResponse;

/**
 * This class build the XML for a Nominet EPP contact:delete command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Contact extends AbstractDelete
{
    const TYPE = 'contact'; //For possible Abstracting later
    const DELETE_NAMESPACE = 'urn:ietf:params:xml:ns:contact-1.0';
    const VALUE_NAME = 'id';

    protected $contact = '';
    protected $value;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(
            self::TYPE,
            self::DELETE_NAMESPACE,
            self::VALUE_NAME,
            new DeleteContactResponse()
        );
    }
}
