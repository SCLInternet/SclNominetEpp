<?php

namespace SclNominetEpp\Response;

use DateTime;
use SclNominetEpp\Contact;

/**
 * This class interprets XML for a Nominet EPP host:create command response.
 * 
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class CreateContact extends Response
{
    protected $contact;
    
    public function processData($xml)
    {
        if (!isset($xml->response->resData)) {
            return;
        }
        $ns = $xml->getNamespaces(true);
        $this->contact = new Contact();
        
        $response = $xml->response;

        $creData  = $response->resData->children($ns['contact'])->creData;
        $this->domain->setId($creData->id);
        $this->domain->setCreated(new DateTime($creData->crDate));
    }

    public function getContact()
    {
        return $this->contact;
    }
}
