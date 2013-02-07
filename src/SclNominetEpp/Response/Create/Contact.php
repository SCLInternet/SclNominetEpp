<?php

namespace SclNominetEpp\Response\Create;

use DateTime;
use SclNominetEpp\Contact;

/**
 * This class interprets XML for a Nominet EPP host:create command response.
 * 
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Contact extends Response
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
        $this->contact->setId($creData->id);
        $this->contact->setCreated(new DateTime($creData->crDate));
    }

    public function getContact()
    {
        return $this->contact;
    }
}
