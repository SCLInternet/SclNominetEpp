<?php

namespace SclNominetEpp\Response\Check;

/**
 * This class interprets XML for a Nominet EPP contact:check command response.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Contact extends AbstractCheck
{
    const TYPE = 'contact';
    const VALUE_NAME = 'id';

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
