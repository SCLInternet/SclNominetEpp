<?php

namespace SclNominetEpp\Response\Info;

use SclNominetEpp\Response;
use DateTime;
use SclNominetEpp\Domain as DomainObject;
use SclNominetEpp\Nameserver;

/**
 * This class interprets XML for a Nominet EPP info command response.
 * @todo this class is based on the Response Info Domain Class, 
 * anything "domain" specific should be generalised, report to the author below.
 * 
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
abstract class AbstractInfo extends Response
{
    protected $object;

    public function processData($xml)
    {
        if($this->xmlInvalid($xml)){
            return;
        }

        $ns = $xml->getNamespaces(true);
        $this->object = new DomainObject();
        $response = $xml->response;

        $infData = $response->resData->children($ns["{$this->type}"])->infData;
        $extension = $response->extension->children($ns["{$this->type}-nom-ext"])->infData;

        $nschildren = $infData->ns->hostObj;
        foreach ($nschildren as $nschild) {
            $nameserver = new Nameserver();
            $nameserver->setHostName($nschild);
            $this->domain->addNameserver($nameserver);
        }

        $this->domain->setName($infData->name);
        $this->domain->setRegistrant($infData->registrant);

        $this->domain->setClientID($infData->clID);
        $this->domain->setCreatorID($infData->crID);
        $this->domain->setCreated(new DateTime((string) $infData->crDate));
        $this->domain->setExpired(new DateTime((string) $infData->exDate));
        $this->domain->setUpID($infData->upID);
        $this->domain->setUpDate(new DateTime((string) $infData->upDate));

        //EXTENSION DATA
        $this->domain->setRegStatus($extension->{'reg-status'});
        $this->domain->setFirstBill($extension->{'first-bill'});
        $this->domain->setRecurBill($extension->{'recur-bill'});
        $this->domain->setAutoBill($extension->{'auto-bill'});
        $this->domain->setNextBill($extension->{'next-bill'});
    }

    /**
     * Assuming $xml is invalid, 
     * this function returns "true" to affirm that the xml is invalid, 
     * otherwise "false".
     * 
     * @param SimpleXMLElement $xml
     * @return boolean
     */
    protected function xmlInvalid(\SimpleXMLElement $xml)
    {   
        return !isset($xml->response->resData);
    }
    
    abstract protected function addSpecificData(\SimpleXMLElement $xml);
    
    public function getDomain()
    {
        return $this->domain;
    }
}
