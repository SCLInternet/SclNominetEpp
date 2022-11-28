<?php

namespace SclNominetEpp\Response\Info;

use SimpleXMLElement;
use SclNominetEpp\Contact as ContactObject;
use SclNominetEpp\Address;

use SclContact\Country;
use SclContact\Postcode;
use SclContact\Email;
use SclContact\PersonName;
use SclContact\PhoneNumber;

/**
 * This class interprets XML for a Nominet EPP contact:info command response.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Contact extends AbstractInfo
{
    const TYPE = 'contact';
    const VALUE_NAME = 'id';

    public function __construct()
    {
        parent::__construct(
            self::TYPE,
            new ContactObject(),
            self::VALUE_NAME
        );
    }

    public function addInfData(SimpleXMLElement $infData)
    {
        $postalInfo = $infData->postalInfo;
        $addrXml    = $postalInfo->addr;

        //toString ADDRESS XML
        $streets = $addrXml->street;

        //ADDRESS SETTING
        $address = new Address();
        $address->setLine1($streets[0]);
        $address->setLine2($streets[1]);
        $address->setCity($addrXml->city);
            $country = new Country();
            $country->setCode($addrXml->cc);
        $address->setCountry($country);
        $address->setCounty($addrXml->sp);
            $postcode = new Postcode();
            $postcode->set($addrXml->pc);
        $address->setPostCode($postcode);

        //NORMAL DATA
            $email = new Email();
            $email->set($infData->email);
        $this->object->setEmail($email);
        if ($infData->fax) {
            $this->object->setFax(new PhoneNumber($infData->fax));
        }
            $phoneNumber = new PhoneNumber();
            $phoneNumber->set($infData->voice);
        $this->object->setPhone($phoneNumber); //optional
            //Postal Info
            $name = explode(" ", $postalInfo->name);
            $last = array_pop($name);
            $first = implode(" ", $name);
            $personName = new PersonName();
            $personName->setFirstName($first);
            $personName->setLastName($last);
        $this->object->setName($personName); //Postal Info
        $this->object->setCompany($postalInfo->org);
        $this->object->setAddress($address);         //Postal Info
    }
    /**
     *
     * @param SimpleXMLElement $extension
     */
    protected function addExtensionData(SimpleXMLElement $extension = null)
    {
        //EXTENSION DATA

        $this->object->setCompanyNumber($extension->{'co-no'});
        $optOut     = strtolower((string) $extension->{'opt-out'});
        if ('n' === $optOut) {
            $optOut = false;
        } else {
            $optOut = true;
        }
        $this->object->setOptOut($optOut);
        $this->object->setTradeName($extension->{'trad-name'});
        $this->object->setType($extension->{'type'});
    }

    /**
     *
     * @param SimpleXMLElement $id
     */
    protected function setValue(SimpleXMLElement $id)
    {
        $this->object->setId((string)$id);
    }

    public function getContact()
    {
        return $this->object;
    }
}
