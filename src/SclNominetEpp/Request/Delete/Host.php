<?php

namespace SclNominetEpp\Request\Delete;

use SclNominetEpp\Response\Delete\Host as DeleteHostResponse;

/**
 * This class build the XML for a Nominet EPP host:delete command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Host extends AbstractDelete
{
    const TYPE = 'host'; //For possible Abstracting later
    const DELETE_NAMESPACE = 'urn:ietf:params:xml:ns:host-1.0';
    const VALUE_NAME = 'name';

    protected $host = '';
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
            new DeleteHostResponse()
        );
    }
}
