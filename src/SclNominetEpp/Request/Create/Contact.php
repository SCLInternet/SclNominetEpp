<?php

namespace SclNominetEpp\Request\Create;

use SimpleXMLElement;
use SclNominetEpp\Contact as ContactObject;
use SclNominetEpp\Response\Create\Contact as CreateContactResponse;
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

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(
            self::TYPE,
            self::CREATE_NAMESPACE,
            self::VALUE_NAME,
            new CreateContactResponse()
        );
    }

    /**
     * This function is used to add Object specific content
     * to the Abstract class' implementation of addContent
     *
     * @param SimpleXMLElement $create
     */
    protected function addSpecificContent(SimpleXMLElement $create)
    {
        $address = $this->object->getAddress();

        $postalInfo = $create->addChild('postalInfo');
        $postalInfo->addAttribute('type', 'int');
        $postalInfo->addChild('name', (string)$this->object->getName());
        $postalInfo->addChild('org', $this->object->getCompany());

        $addr = $postalInfo->addChild('addr');
        $addr->addChild('street', $address->getLine1());
        $addr->addChild('street', $address->getLine2());
        $addr->addChild('city', $address->getCity());
        $addr->addChild('sp', $address->getCounty());
        $addr->addChild('pc', $address->getPostCode());
        $addr->addChild('cc', $address->getCountry());

        $create->addChild('voice', $this->object->getPhone()->get());
        $create->addChild('email', $this->object->getEmail()->get());

        //Mandatory for EPP but not used by nominet
        $authInfo = $create->addChild('authInfo');
        $authInfo->addChild('pw', self::DUMMY_PASSWORD);
    }

    /**
     * An Exception is thrown if the object is not of type \SclNominetEpp\Contact
     *
     * @throws Exception
     */
    public function objectValidate($contact)
    {
        if (!$contact instanceof ContactObject) {
            $exception = sprintf('A valid contact object was not passed to CreateContact, Ln:%d', __LINE__);
            throw new Exception($exception);
        }
        return true;
    }

    /**
     * Set Contact to the passed ContactObject file.
     *
     * @param ContactObject $contact
     */
    public function setContact(ContactObject $object)
    {
        $this->object = $object;
    }


    protected function getName()
    {
        return $this->object->getId();
    }
}
