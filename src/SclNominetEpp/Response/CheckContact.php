<?php

namespace SclNominetEpp\Response;

/**
 * This class interprets XML for a Nominet EPP contact:check command response.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class CheckContact extends AbstractCheck
{   
    const TYPE = 'contact';
    const VALUE_NAME = 'id';
    
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
