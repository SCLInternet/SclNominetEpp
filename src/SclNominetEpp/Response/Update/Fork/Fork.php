<?php

namespace SclNominetEpp\Response\Update\Fork;

use SclNominetEpp\Response;

/**
 * This class interprets XML for a Nominet EPP fork command response.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Fork extends Response
{
    /**
     * {@inheritDoc}
     * 
     * @param \SimpleXMLElement $xml
     * @return void
     */
    protected function processData(SimpleXMLElement $xml)
    {
        if (!$this->xmlValid($xml->response->resData)) {
            return;
        }
        
        $ns = $xml->getNamespaces(true);

        $contactDetails = $xml->response->resData->children($ns['contact'])->creData;
        $contactDetails->id;
        $contactDetails->crDate;

    }
}
