<?php

namespace SclNominetEpp\Request\Create;

use SclNominetEpp\Contact as ContactObject;
use Exception;

/**
 * This class build the XML for a Nominet EPP contact:create command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Contact extends AbstractCreate
{

    const TYPE = 'contact';
    const CREATE_NAMESPACE = 'urn:ietf:params:xml:ns:contact-1.0';
    const VALUE_NAME = 'id';
    const DUMMY_PASSWORD = 'qwerty';

    /**
     *
     * @var ContactObject
     */
    protected $contact = null;

    /**
     *
     * @var string
     */
    protected $value;

    public function __construct()
    {
        $this->value = $this->contact->getId();
        parent::__construct(
            self::TYPE,
            new CheckContactResponse(),
            self::CREATE_NAMESPACE,
            self::VALUE_NAME,
            $this->value
        );
    }
    
    public function addSpecificContent($create)
    {
        $address = $this->contact->getAddress();
        
        $postalInfo = $create->addChild('postalInfo');
        $postalInfo->addAttribute('type', 'int');
        $postalInfo->addChild('name', $this->contact->getName());
        $postalInfo->addChild('org', $this->contact->getOrganisation());

        $addr = $postalInfo->addChild('addr');
        $addr->addChild('street', $address->getAddressLineOne());
        $addr->addChild('street', $address->getAddressLineTwo());
        $addr->addChild('street', $address->getAddressLineThree());
        $addr->addChild('city', $address->getCity());
        $addr->addChild('sp', $address->getStateProvince());
        $addr->addChild('pc', $address->getPostCode());
        $addr->addChild('cc', $address->getCountryCode());

        $create->addChild('voice', $this->contact->getPhone());
        $create->addChild('email', $this->contact->getEmail());

        //Mandatory for EPP but not used by nominet
        $authInfo = $create->addChild('authInfo');
        $authInfo->addChild('pw', self::DUMMY_PASSWORD);
    }
    
    public function objectValidate(){
        if (!$this->contact instanceof ContactObject) {
            $exception = sprintf('A valid contact object was not passed to CreateContact, Ln:%d', __LINE__);
            throw new Exception($exception);
        }
    }
    
    /**
     *
     * @param Contact $contact
     */
    public function setContact(ContactObject $contact)
    {
        $this->contact = $contact;
    }
}
