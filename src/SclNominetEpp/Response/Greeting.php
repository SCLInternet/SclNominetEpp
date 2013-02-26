<?php

namespace SclNominetEpp\Response;

use SclNominetEpp\Response;

/**
 * This class interprets XML for a Nominet EPP list command response.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Greeting extends Response
{
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
        if (!$this->xmlValid($xml)) {
            return;
        }

        $ns = $xml->getNamespaces(true);

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
}
