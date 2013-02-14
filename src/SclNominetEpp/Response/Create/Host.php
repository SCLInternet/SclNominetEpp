<?php

namespace SclNominetEpp\Response\Create;

use DateTime;
use SclNominetEpp\Nameserver;

/**
 * This class interprets XML for a Nominet EPP host:create command response.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Host extends AbstractCreate
{
    const TYPE = 'host';
    const OBJECT_TYPE = '\SclNominetEpp\Nameserver';
    
    protected $host;

    public function __construct()
    {
        parent::__construct(null);
        parent::setType(self::TYPE);
        parent::setObjectType(self::OBJECT_TYPE);
    }
    
    public function setValue($name)
    {
        $this->host->setHostName($name);
    }

    protected function addSpecificData(\SimpleXMLElement $xml) {}
}
