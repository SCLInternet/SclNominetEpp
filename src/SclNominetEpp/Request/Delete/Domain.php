<?php

namespace SclNominetEpp\Request\Delete;

use SclNominetEpp\Response\Delete\Domain as DeleteDomainResponse;

/**
 * This class build the XML for a Nominet EPP domain:delete command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Domain extends AbstractDelete
{
    const TYPE = 'domain'; //For possible Abstracting later
    const DELETE_NAMESPACE = 'urn:ietf:params:xml:ns:domain-1.0';
    const VALUE_NAME = 'name';

    protected $domain = '';
    protected $value;

    public function __construct()
    {
        parent::__construct(
            self::TYPE,
            new DeleteDomainResponse(),
            self::DELETE_NAMESPACE,
            self::VALUE_NAME
        );
    }
}
