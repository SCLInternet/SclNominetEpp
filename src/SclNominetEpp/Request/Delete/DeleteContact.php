<?php

namespace SclNominetEpp\Request;

use SclNominetEpp\Response\DeleteContact as DeleteContactResponse;

/**
 * This class build the XML for a Nominet EPP contact:delete command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class DeleteContact extends AbstractDelete
{
    const TYPE = 'contact'; //For possible Abstracting later
    const DELETE_NAMESPACE = 'urn:ietf:params:xml:ns:contact-1.0';
    const VALUE_NAME = 'id';

    protected $contact = '';
    protected $value;
    
    public function __construct()
    {
        parent::__construct(
            self::TYPE,
            new DeleteContactResponse(),
            self::DELETE_NAMESPACE,
            self::VALUE_NAME
        );
    }
}
