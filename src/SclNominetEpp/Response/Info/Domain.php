<?php

namespace SclNominetEpp\Response\Info;

use SclNominetEpp\Response;
use DateTime;
use SclNominetEpp\Domain as DomainObject;
use SclNominetEpp\Nameserver;

/**
 * This class interprets XML for a Nominet EPP domain:info command response.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Domain extends Response
{
    protected $domain;

    public function processData($xml)
    {
        if (!isset($xml->response->resData)) {
            return;
        }

        $ns = $xml->getNamespaces(true);
        $this->domain = new DomainObject();
        $response = $xml->response;

        $infData = $response->resData->children($ns['domain'])->infData;
        $extension = $response->extension->children($ns['domain-nom-ext'])->infData;

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

        $this->domain->setRegStatus($extension->{'reg-status'});
        $this->domain->setFirstBill($extension->{'first-bill'});
        $this->domain->setRecurBill($extension->{'recur-bill'});
        $this->domain->setAutoBill($extension->{'auto-bill'});
        $this->domain->setNextBill($extension->{'next-bill'});
    }

    public function getDomain()
    {
        return $this->domain;
    }
}
