<?php

namespace SclNominetEpp\Response;

use SclNominetEpp\Response;

/**
 * This class interprets XML for a Nominet EPP renew command response.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Fork extends Response
{
    /**
     * @todo Tom, what's the return type?
     * @param \SimpleXMLElement $xml
     * @return mixed
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
