<?php

namespace SclNominetEpp\Response\Check;

/**
 * This class interprets XML for a Nominet EPP host:check command response.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Host extends AbstractCheck
{
    const TYPE = 'host';
    const VALUE_NAME = 'name';

    /**
     *Constructor
     */
    public function __construct()
    {
        parent::__construct(
            self::TYPE,
            self::VALUE_NAME
        );
    }
}
