<?php

namespace SclNominetEpp\Response;

/**
 * This class interprets XML for a Nominet EPP host:check command response.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class CheckHost extends AbstractCheck
{
    const TYPE = 'host';
    const VALUE_NAME = 'name';
    
    public function __construct($data = null)
    {
        parent::__construct(null);
        parent::setType(self::TYPE);
        parent::setValueName(self::VALUE_NAME);
    }
}
