<?php

namespace SclNominetEpp\Response;

/**
 * This class interprets XML for a Nominet EPP contact:check command response.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class CheckContact extends AbstractCheck
{
    protected $contacts;
    
    const TYPE = 'contact';
    const VALUE_NAME = 'id';
    
    public function __construct($data = null)
    {
        parent::__construct(null);
        parent::setType(self::TYPE);
        parent::setValueName(self::VALUE_NAME);
    }
    
    
            
    
//    protected function processData($data)
//    {
//        if (!isset($data->response->resData)) {
//            return;
//        }
//
//        $ns = $data->getNamespaces(true);
//
//        $contacts = $data->response->resData->children($ns['contact']);
//
//        $this->contacts = array();
//
//        foreach ($contacts->chkData->cd as $contact) {
//            $this->contacts[(string)$contact->id] = (boolean)(string)$contact->id->attributes()->avail;
//        }
//    }
    
//    public function getContacts()
//    {
//        return $this->contacts;
//    }
}
