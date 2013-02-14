<?php

namespace SclNominetEpp\Response\Create;

use DateTime;
use SclNominetEpp\Response;
use SclNominetEpp\Contact as ContactObject;

/**
 * This class interprets XML for a Nominet EPP host:create command response.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Contact extends AbstractCreate
{
    const TYPE = 'contact';
    const OBJECT_TYPE = 'ContactObject';
    
    protected $contact;

    public function __construct()
    {
        parent::__construct(null);
        parent::setType(self::TYPE);
        parent::setObjectType(self::OBJECT_TYPE);
    }
    
    public function processData($xml)
    {
        if($this->xmlInvalid($xml)){
            return;
        }
        
        $ns = $xml->getNamespaces(true);
        $this->contact = new ContactObject();

        $response = $xml->response;

        $creData  = $response->resData->children($ns['contact'])->creData;
        $this->contact->setId($creData->id);
        $this->contact->setCreated(new DateTime($creData->crDate));
    }


    public function getContact()
    {
        return $this->contact;
    }

    protected function addSpecificData() {
        
    }
}
