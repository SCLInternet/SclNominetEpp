<?php
namespace SclNominetEpp\Request;

use SclNominetEpp\Contact;
use SclNominetEpp\Address;
use SclNominetEpp\Nameserver;
use DateTime;

/**
 */
class CreateContactTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->request = new CreateContact();
    }


    /**
     */
    public function testCreateDomain()
    {
        $xml = <<<EOX
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<epp xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="urn:ietf:params:xml:ns:epp-1.0" xsi:schemaLocation="urn:ietf:params:xml:ns:epp-1.0 epp-1.0.xsd">
  <command>
    <create>
      <contact:create xmlns:contact="urn:ietf:params:xml:ns:contact-1.0">
        <contact:id>sc2343</contact:id>
        <contact:postalInfo type="int">
          <contact:name>name</contact:name>
          <contact:org>sclMerlyn</contact:org>
          <contact:addr>
            <contact:street>Bryn Seion Chapel</contact:street>
            <contact:street/>
            <contact:street/>
            <contact:city>Cardigan</contact:city>
            <contact:sp>Ceredigion</contact:sp>
            <contact:pc>SA43 2HB</contact:pc>
            <contact:cc>US</contact:cc>
          </contact:addr>
        </contact:postalInfo>
        <contact:voice>+44.3344555666</contact:voice>
        <contact:email>example@email.com</contact:email>
        <contact:authInfo>
          <contact:pw>qwerty</contact:pw>
        </contact:authInfo>
      </contact:create>
    </create>
  </command>
</epp>

EOX;

        $contact = new \SclNominetEpp\Contact();
        $contact->setId('sc2343');
        $contact->setName('name');
        $contact->setEmail('example@email.com');

        /*
        * The contact address.
        * which comprises of the (addressLineOne, city, cc, addressLineTwo, addressLineThree, sp, pc);
        *
        */
        $address = new Address();
        $address->setAddressLineOne('Bryn Seion Chapel');
        $address->setCity('Cardigan');
        $address->setCountryCode('US');
        $address->setStateProvince('Ceredigion');
        $address->setPostCode('SA43 2HB');
        $contact->setAddress($address);

        $contact->setCompanyNumber('NI65786');
        // The registered company number or the DfES UK school number of the registrant.
        $contact->setPhone('+44.3344555666');
        $contact->setOrganisation('sclMerlyn');
        $contact->setFax('+443344555616');
        $contact->setOptOut('y');
        
        $this->request->setContact($contact);

        $this->assertEquals($xml, $this->request->getPacket());
    }
}
