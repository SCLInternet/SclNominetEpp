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
     * 
     * @param type $data
     */
    public function __construct($data = null)
    {
        parent::__construct(null);
        parent::setType(self::TYPE);
        parent::setValueName(self::VALUE_NAME);
    }
}
