<?php

namespace SclNominetEpp\Response\Create;

use DateTime;
use SclNominetEpp\Response;
use SclNominetEpp\Domain as DomainObject;

/**
 * This class interprets XML for a Nominet EPP host:create command response.
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

        $creData  = $response->resData->children($ns['domain'])->creData;
        $this->domain->setName($creData->name);
        $this->domain->setCreated(new DateTime($creData->crDate));
        $this->domain->setExpired(new DateTime($creData->exDate));
    }

    public function getDomain()
    {
        return $this->domain;
    }
}
