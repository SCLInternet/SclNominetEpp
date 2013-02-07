<?php

namespace SclNominetEpp\Request;

use SclNominetEpp\Response\DeleteHost as DeleteHostResponse;

/**
 * This class build the XML for a Nominet EPP host:delete command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class DeleteHost extends Request
{
    const TYPE = 'host'; //For possible Abstracting later
    const DELETE_NAMESPACE = 'urn:ietf:params:xml:ns:host-1.0';
    const VALUE_NAME = 'name';

    protected $contact = '';
    protected $value;
    
    public function __construct()
    {
        parent::__construct(
            self::TYPE,
            new DeleteHostResponse(),
            self::DELETE_NAMESPACE,
            self::VALUE_NAME
        );
    }
}
