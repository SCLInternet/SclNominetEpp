<?php

namespace SclNominetEpp\Response\Update;

use DateTime;
use SclNominetEpp\Response;
use SimpleXMLElement;

/**
 * This class interprets XML for a Nominet EPP fork command response.
 */
class Fork extends Response
{
    /**
     * New contact identifier.
     *
     * @var string
     */
    protected $contactId;

    /**
     * The Date of contact creation.
     *
     * @var DateTime
     */
    protected $createDate;

    protected function processData(SimpleXMLElement $xml)
    {
        if (!$this->success()) {
            return;
        }
        if (!$this->xmlValid($xml)) {
            return;
        }
        $ns = $xml->getNamespaces(true);

        $contactDetails = $xml->response->resData->children($ns['contact'])->creData;
        $this->contactId = $contactDetails->id;
        $this->createDate = $contactDetails->crDate;
    }
}
