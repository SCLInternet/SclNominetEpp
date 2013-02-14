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
    const OBJECT_TYPE = 'Nameserver';
    
    protected $host;

    public function __construct()
    {
        parent::__construct(null);
        parent::setType(self::TYPE);
        parent::setObjectType(self::OBJECT_TYPE);
    }
    
    public function processData($xml)
    {
        if ($this->xmlInvalid($xml)) {
            return;
        }
        $ns = $xml->getNamespaces(true);
        $this->host = new Nameserver();

        $response  = $xml->response;

        $creData   = $response->resData->children($ns['host'])->creData;
        $this->host->setHostName($creData->name);
        $this->host->setCreated(new DateTime($creData->crDate));
    }

    public function getHost()
    {
        return $this->host;
    }

    protected function addSpecificData() {
        
    }
}
