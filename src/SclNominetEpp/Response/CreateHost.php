<?php

namespace SclNominetEpp\Response;

use DateTime;
use SclNominetEpp\Nameserver;

/**
 * This class interprets XML for a Nominet EPP host:create command response.
 * 
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class CreateHost extends Response
{
    protected $host;
    
    public function processData($xml)
    {
        if (!isset($xml->response->resData)) {
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
}
