<?php

namespace SclNominetEpp\Response\Create;

use DateTime;
use SclNominetEpp\Domain as DomainObject;

/**
 * This class gives AbstractCreate information to interpret XML 
 * for a Nominet EPP host:create command response.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Domain extends AbstractCreate
{
    const TYPE = 'domain';
    const VALUE_NAME = 'name';
    
    protected $domain;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(
            self::TYPE,
            new DomainObject(),
            self::VALUE_NAME
        );
    }
    
    /**
     * Overriding setter of AbstractCreate Response
     * 
     * @param string $name
     */
    protected function setIdentifier($name)
    {
        $this->object->setName($name);
    }

    protected function addSpecificData(SimpleXMLElement $creData)
    {
        
        $this->object->setExpired(new DateTime($creData->exDate));
    }
}
