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
     *
     * @param type $data
     */
    public function __construct()
    {
        parent::__construct();
        parent::setType(self::TYPE);
        parent::setValueName(self::VALUE_NAME);
    }
}
