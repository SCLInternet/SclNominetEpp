<?php

namespace SclNominetEpp\Response\Update\Handshake;

use SclNominetEpp\Response;
use SclNominetEpp\Handshake as HandshakeObject;
use SimpleXMLElement;

/**
 * This class interprets XML for a Nominet EPP list command response.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Handshake extends Response
{
    /**
     * A handshake object for response information gathering.
     * 
     * @var HandshakeObject 
     */
    private $handshake;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->handshake = new HandshakeObject();
    }
    
    /**
     * {@inheritDoc}
     * 
     * @param SimpleXMLElement $xml
     * @return void
     */
    protected function processData(SimpleXMLElement $xml)
    {
        if (!$this->success()) {
            return;
        }
        if (!$this->xmlValid($xml->response->resData)) {
            return;
        }
        
        $ns             = $xml->getNamespaces(true);
        $response       = $xml->response;
        
        $handshakeData  = $response->resData->children($ns["h:hanData"]);
        
        $this->handshake->setCaseId($handshakeData->caseId);
        $domainListData = $handshakeData->domainListData;
        $registrant     = $handshakeData->registrant;
        $attributeArray = $domainListData->attributes();
        $this->handshake->getNumberOfDomains($attributeArray['noDomains']);
        
        if ($this->xmlValid($domainListData)) {
            foreach ($domainListData as $domain) {
                $this->handshake->addDomain($domain);
            }
        }
        if ($this->xmlValid($registrant)) {
            $this->handshake->setRegistrant($registrant);
        }
    }

    
    public function xmlValid(SimpleXMLElement $xml)
    {
        return isset($xml);
    }
      
    public function getHandshake()
    {
        return $this->handshake;
    }
}
