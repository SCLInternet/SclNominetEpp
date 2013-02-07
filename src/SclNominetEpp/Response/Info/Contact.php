<?php

namespace SclNominetEpp\Response;

use SclNominetEpp\Response;
use SclNominetEpp\Contact as ContactObject;
use SclNominetEpp\Address;
use DateTime;

/**
 * This class interprets XML for a Nominet EPP contact:info command response.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Contact extends Response
{
    protected $contact;
    //put your code here
    public function processData($xml)
    {
        if (!isset($xml->response->resData)) {
            return;
        }
        
        $ns = $xml->getNamespaces(true);
        $this->contact = new ContactObject();

        $response  = $xml->response;

        $infData   = $response->resData->children($ns['contact'])->infData;
        $extension = $response->extension->children($ns['contact-nom-ext'])->infData;

        $postalInfo = $infData->postalInfo;
        $addrXml    = $postalInfo->addr;

        //toString ADDRESS XML

        $streets = $addrXml->street;

        //ADDRESS SETTING

        $address = new Address();
        $address->setAddressLineOne($streets[0]);
        $address->setAddressLineTwo($streets[1]);
        $address->setAddressLineThree($streets[2]);
        $address->setCity($addrXml->city);
        $address->setCountryCode($addrXml->cc);
        $address->setStateProvince($addrXml->sp);
        $address->setPostCode($addrXml->pc);

        //EXTENSION DATA

        $this->contact->setCompanyNumber($extension->{'co-no'});
        $optOut     = strtolower((string)$extension->{'opt-out'});
        if ('n' === $optOut) {
            $optOut = false;
        } else {
            $optOut = true;
        }
        $this->contact->setOptOut($optOut);
        $this->contact->setTradeName($extension->{'trad-name'});
        $this->contact->setType($extension->{'type'});

        //NORMAL DATA

        $this->contact->setID($infData->id);
        $this->contact->setEmail($infData->email);
        $this->contact->setFax($infData->fax);
        $this->contact->setPhone($infData->voice); //optional

            //Dates
        $this->contact->setCreated(new DateTime((string)$infData->crDate));
        $this->contact->setUpDate(new DateTime((string)$infData->upDate));
            //Postal Info
        $this->contact->setName($postalInfo->name); //Postal Info
        $this->contact->setOrganisation($postalInfo->org);
        $this->contact->setAddress($address);         //Postal Info
    }

    public function getContact()
    {
        return $this->contact;
    }
}
