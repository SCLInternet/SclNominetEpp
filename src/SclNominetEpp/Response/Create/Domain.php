<?php

namespace SclNominetEpp\Response\Create;

use DateTime;
use SclNominetEpp\Domain as DomainObject;

/**
 * This class interprets XML for a Nominet EPP host:create command response.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Domain extends AbstractCreate
{
    const TYPE = 'domain';
    const OBJECT_TYPE = '\SclNominetEpp\Domain';
    
    protected $domain;

    public function __construct()
    {
        parent::__construct(null);
        parent::setType(self::TYPE);
        parent::setObjectType(self::OBJECT_TYPE);
    }
        
    public function setValue($name)
    {
        $this->host->setName($name);
    }

    protected function addSpecificData(\SimpleXMLElement $creData) {
        
        $this->domain->setExpired(new DateTime($creData->exDate));
    }
}
