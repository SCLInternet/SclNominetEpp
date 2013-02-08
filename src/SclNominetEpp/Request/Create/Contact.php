<?php

namespace SclNominetEpp\Request\Create;

use SimpleXMLElement;
use SclNominetEpp\Request;
use SclNominetEpp\Contact as ContactObject;
use Exception;

/**
 * This class build the XML for a Nominet EPP contact:create command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Contact extends Request
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
        parent::__construct('create');
    }

    /**
     *
     * @param  SimpleXMLElement $xml
     * @throws Exception
     */
    public function addContent(SimpleXMLElement $xml)
    {
        if (!$this->contact instanceof ContactObject) {
            $exception = sprintf('A valid contact object was not passed to CreateContact, Ln:%d', __LINE__);
            throw new Exception($exception);
        }

        $address = $this->contact->getAddress();

        $create = $xml->addChild("contact:create", '', self::CREATE_NAMESPACE);

        $create->addChild(self::VALUE_NAME, $this->contact->getId(), self::CREATE_NAMESPACE);

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

    /**
     *
     * @param Contact $contact
     */
    public function setContact(ContactObject $contact)
    {
        $this->contact = $contact;
    }
}
