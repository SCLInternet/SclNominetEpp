<?php

namespace SclNominetEpp\Request\Create;

use SclContact\Country;
use SclContact\Email;
use SclContact\PersonName;
use SclContact\PhoneNumber;
use SclContact\Postcode;
use SclNominetEpp\Address;
use SclNominetEpp\Contact;
use SclNominetEpp\Request;
use SclNominetEpp\Request\Create\Contact as CreateContact;

/**
 * contact:create test
 */
class ContactTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Request
     */
    protected $request;

    /**
     *
     */
    public function testCreateContact()
    {
        $xml = <<<EOX
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<epp xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="urn:ietf:params:xml:ns:epp-1.0" xsi:schemaLocation="urn:ietf:params:xml:ns:epp-1.0 epp-1.0.xsd">
  <command>
    <create>
      <contact:create xmlns:contact="urn:ietf:params:xml:ns:contact-1.0">
        <contact:id>sc2343</contact:id>
        <contact:postalInfo type="int">
          <contact:name>first last</contact:name>
          <contact:org>sclMerlyn</contact:org>
          <contact:addr>
            <contact:street>Bryn Seion Chapel</contact:street>
            <contact:street/>
            <contact:city>Cardigan</contact:city>
            <contact:sp>Ceredigion</contact:sp>
            <contact:pc>SA43 2HB</contact:pc>
            <contact:cc>US</contact:cc>
          </contact:addr>
        </contact:postalInfo>
        <contact:voice>+44.3344555666</contact:voice>
        <contact:email>example@email.com</contact:email>
      </contact:create>
    </create>
  </command>
</epp>

EOX;

        $contact = new Contact();
        $contact->setId('sc2343');

        $personName = new PersonName;
        $personName->setFirstName('first');
        $personName->setLastName('last');
        $contact->setName($personName);

        $email = new Email();
        $email->set('example@email.com');
        $contact->setEmail($email);

        /*
        * The contact address.
        * which comprises of the (Line1, city, cc, Line2, sp, pc);
        *
        */
        $address = new Address();
        $address->setLine1('Bryn Seion Chapel');
        $address->setCity('Cardigan');

        $country = new Country();
        $country->setCode('US');
        $address->setCountry($country);

        $address->setCounty('Ceredigion');

        $postCode = new Postcode();
        $postCode->set('SA43 2HB');
        $address->setPostCode($postCode);
        $contact->setAddress($address);

        $contact->setCompanyNumber('NI65786');

        $phoneNumber = new PhoneNumber();
        $phoneNumber->set('+44.3344555666');
        // The registered company number or the DfES UK school number of the registrant.
        $contact->setPhone($phoneNumber);
        $contact->setCompany('sclMerlyn');
        $fax = new PhoneNumber();
        $fax->set('+443344555616');
        $contact->setOptOut('y');

        $this->request->setContact($contact);

        $this->assertEquals($xml, $this->request->getPacket());
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->request = new CreateContact();
    }
}
