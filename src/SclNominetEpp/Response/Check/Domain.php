<?php

namespace SclNominetEpp\Response\Check;

/**
 * This class interprets XML for a Nominet EPP domain:check command response.
 *
 * @author tom
 */
class Domain extends AbstractCheck
{
    const TYPE = 'domain';
    const VALUE_NAME = 'name';

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(
            self::TYPE,
            self::VALUE_NAME
        );
    }
}
