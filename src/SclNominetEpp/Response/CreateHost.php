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

        $infData   = $response->resData->children($ns['host'])->infData;
        $this->host->setHostName($infData->name);
        $this->assignStataiToHost($infData->status);
        $this->assignIpsToHost($infData->addr);
        $this->host->setClientID($infData->clID);
        $this->host->setCreatorID($infData->crID);
        $this->host->setCreated(new DateTime($infData->crDate));
    }
    
    public function assignStataiToHost($statai)
    {
        foreach ($statai as $status) {
            $attributes = $status->attributes();
            if (null == $attributes->s) {
                $this->host->addStatus('ok');
            } else {
                $this->host->addStatus($attributes->s);
            }
        }
    }
    
    public function assignIpsToHost($addresses)
    {
        foreach ($addresses as $ip) {
            $attributes = $ip->attributes();
            
            if ($attributes->ip == 'v4') {
                $this->host->setIpv4($ip);
            } else {
                $this->host->setIpv6($ip);
            }
        }
    }

    public function getHost()
    {
        return $this->host;
    }
}
