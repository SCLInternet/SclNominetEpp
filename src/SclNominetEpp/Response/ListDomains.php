<?php

namespace SclNominetEpp\Response;

use SclNominetEpp\Response;
use SimpleXMLElement;

/**
 * This class interprets XML for a Nominet EPP list command response.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class ListDomains extends Response
{
    const LIST_MONTH  = 1;
    const LIST_EXPIRY = 2;

    protected $domains = array();

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

        $ns = $xml->getNamespaces(true);

        $domains = $xml->response->resData->children($ns['list'])->listData;

        foreach ($domains->domainName as $domain) {
            $this->domains[] = (string) $domain;
        }
    }

    /**
     *
     * @param \SimpleXMLElement $xml
     * @return boolean
     */
    public function xmlValid(SimpleXMLElement $xml)
    {
        return isset($xml);
    }

    /**
     *
     * @return array
     */
    public function getDomains()
    {
        return $this->domains;
    }
}
