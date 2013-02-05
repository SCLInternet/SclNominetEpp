<?php

namespace SclNominetEpp\Response;

use DateTime;
use SclNominetEpp\Domain;

/**
 * This class interprets XML for a Nominet EPP host:create command response.
 * 
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class CreateDomain extends Response
{
    protected $domain;
    
    public function processData($xml)
    {
        if (!isset($xml->response->resData)) {
            return;
        }
        $ns = $xml->getNamespaces(true);
        $this->domain = new Domain();
        
        $response = $xml->response;

        $infData  = $response->resData->children($ns['domain'])->infData;
        $this->domain->setName($infData->name);
//        $statai   = $infData->status;
//        foreach ($statai as $status) {
//            $this->host->addStatus($status);
//        }
//        $addresses = $infData->addr;
//        foreach ($addresses as $type => $ip) {
//            $attributes = $type->attributes();
//            
//            if ($attributes->ip == 'v4') {
//                $this->host->setIpv4($ip);
//            } else {
//                $this->host->setIpv6($ip);
//            }
//        }
        
        $this->domain->setClientID($infData->clID);
        $this->domain->setCreatorID($infData->crID);
        $this->domain->setCreated(new DateTime($infData->crDate));
    }

    public function getDomain()
    {
        return $this->domain;
    }
}
