<?php

namespace SclNominetEpp\Response\Create;

use SclNominetEpp\Contact as ContactObject;

/**
 * This class gives AbstractCreate information to interpret XML 
 * for a Nominet EPP host:create command response.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Contact extends AbstractCreate
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
            new ContactObject(),
            self::VALUE_NAME
        );
    }
    
    /**
     * Overriding setter of AbstractCreate Response
     * 
     * @param string $id
     */
    public function setValue($id)
    {
        $this->object->setId($id);
    }
}
