<?php

namespace SclNominetEpp\Response\Info;

use SclNominetEpp\Response;
use SclNominetEpp\Nameserver;
use SimpleXMLElement;
use DateTime;

/**
 * This class interprets XML for a Nominet EPP host:info command response.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Host extends Response
{
    protected $host;

    public function processData($xml)
    {
        if (!isset($xml->response->resData)) {
            return;
        }
        $ns = $xml->getNamespaces(true);

        $response = $xml->response;

        $infData = $response->resData->children($ns['host'])->infData;

        $this->host = new Nameserver();
        $this->host->setHostName($infData->name);
        $this->statusArrPopulate($infData);
        $this->ipCheck($infData); // sets ipv4 and ipv6:- $this->host->setIpv4 and setIpv6
        $this->host->setClientID($infData->clID);
        $this->host->setCreatorID($infData->crID);
        $this->host->setCreated(new DateTime((string)$infData->crDate));
        $this->host->setUpID($infData->upID);
        if (isset($infData->upDate)) {
            $this->host->setUpDate(new DateTime((string)$infData->upDate));
        }
    }


    /**
     *
     * @param SimpleXMLElement $infData
     * @return string
     */
    public function statusArrPopulate(SimpleXMLElement $infData)
    {
        if (null === $infData->status) {
            return "no status";
        }
        foreach ($infData->status as $s) {
            if (null !== $s->attributes()->s) {
                $this->host->addStatus($s->attributes()->s);
            } else {
                $this->host->addStatus('ok');
            }
        }
    }

    /**
     * ipCheck finds, for all addresses in host,
     * the addresses which are ip "v4" and ip "v6" and
     * associates them to the host object,
     * If there is no "ip" attribute it defaults to "v4".
     *
     * @param SimpleXMLElement $infData
     */
    public function ipCheck(SimpleXMLElement $infData)
    {
        if (!isset($infData->addr)) {
            return;
        }

        foreach ($infData->addr as $address) {
            $type = 'v4';
            if (isset($address->attributes()->ip)) {
                $type = $address->attributes()->ip;
            }
            if ('v6' == $type) {
                $this->host->setIpv6($address);
            } else {
                $this->host->setIpv4($address);
            }
        }
    }

    public function getHost()
    {
        return $this->host;
    }
}
