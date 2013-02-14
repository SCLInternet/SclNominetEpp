<?php

namespace SclNominetEpp\Response\Create;

use DateTime;
use SclNominetEpp\Response;
use SclNominetEpp\Contact as ContactObject;

/**
 * This class interprets XML for a Nominet EPP host:create command response.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Contact extends AbstractCreate
{
    const TYPE = 'contact';
    const OBJECT_TYPE = '\SclNominetEpp\Contact';
    
    protected $contact;

    public function __construct($data = null)
    {
        parent::__construct($data);
        parent::setType(self::TYPE);
        parent::setObjectType(self::OBJECT_TYPE);
    }
    
    public function setValue($name)
    {
        $this->host->setId($name);
    }
}
