<?php

namespace SclNominetEpp\Response;

use SclNominetEpp\Response;

/**
 * This class interprets XML for a Nominet EPP list command response.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Handshake extends Response
{
   
    protected function processData($xml)
    {
        if ($this->xmlInvalid($xml)) {
            return;
        }
        
        $ns             = $xml->getNamespaces(true);
        $response       = $xml->response;
        
        $handshakeData  = $response->resData->children($ns["h:hanData"]);
        
        $domainListData = $handshakeData->domainListData;
        $caseId         = $handshakeData->caseId;
//        foreach ($xmlValues->chkData->cd as $value) {
//            $available = (boolean) (string) $value->$valueName->attributes()->avail;
//            $this->values[(string) $value->$valueName] = $available;
//        }
        //$domainListData->
        //$domainListData->
    }

    
    public function xmlInvalid($xml)
    {
        if (!isset($xml->response->resData)) {
            return;
        }
    }
    
    public function getDomains()
    {
        
    }
}
