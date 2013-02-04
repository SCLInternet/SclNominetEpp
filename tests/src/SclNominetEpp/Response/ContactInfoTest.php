<?php
namespace SclNominetEpp\Response;

use DateTime;

/**
 */
class ContactInfoTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Response
     */
    protected $response;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->response = new ContactInfo();
    }


    /**
     * @covers SclNominetEpp\Response\ContactInfo::processData
     *
     */
    public function testProcessData()
    {

        $xml = <<<EOX
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<epp xmlns="urn:ietf:params:xml:ns:epp-1.0"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.nominet.org.uk/epp/xml/epp-1.0 epp-1.0.xsd">
  <response>
    <result code="1000">
      <msg>Command completed successfully</msg>
    </result>
    <resData>
      <contact:infData
        xmlns:contact="urn:ietf:params:xml:ns:contact-1.0"
        xsi:schemaLocation="urn:ietf:params:xml:ns:contact-1.0 contact-1.0.xsd">
        <contact:id>sc2343</contact:id>
        <contact:roid>50489603-UK</contact:roid>
        <contact:status s="ok"/>
        <contact:postalInfo type="loc">
          <contact:name>name</contact:name>
          <contact:org>sclMerlyn</contact:org>
          <contact:addr>
            <contact:street>Bryn Seion Chapel</contact:street>
            <contact:city>Cardigan</contact:city>
            <contact:sp>Ceredigion</contact:sp>
            <contact:pc>SA43 2HB</contact:pc>
            <contact:cc>US</contact:cc>
          </contact:addr>
        </contact:postalInfo>
        <contact:voice>+44.3344555666</contact:voice>
        <contact:email>example@email.com</contact:email>
        <contact:clID>SCL</contact:clID>
        <contact:crID>EPP-SCL</contact:crID>
        <contact:upDate>2013-01-29T11:09:23</contact:upDate>
        <contact:crDate>2013-01-29T11:09:23</contact:crDate>
      </contact:infData>
    </resData>
    <extension>
      <contact-nom-ext:infData
        xmlns:contact-nom-ext="http://www.nominet.org.uk/epp/xml/contact-nom-ext-1.0"
        xsi:schemaLocation="http://www.nominet.org.uk/epp/xml/contact-nom-ext-1.0 contact-nom-ext-1.0.xsd">
        <contact-nom-ext:trad-name>Big enterprises</contact-nom-ext:trad-name>
        <contact-nom-ext:type>UNKNOWN</contact-nom-ext:type>
        <contact-nom-ext:opt-out>N</contact-nom-ext:opt-out>
        <contact-nom-ext:co-no>5489549</contact-nom-ext:co-no>
      </contact-nom-ext:infData>
    </extension>
    <trID>
      <clTRID>EPP-SCL</clTRID>
      <svTRID>248836</svTRID>
    </trID>
  </response>
</epp>

EOX;


        $expected = new \SclNominetEpp\Contact;

        $expected->setId('sc2343');
        $expected->setCreated(new DateTime('2013-01-29T11:09:23'));
        $expected->setUpDate(new DateTime('2013-01-29T11:09:23'));
        $expected->setName('name');
        $expected->setOrganisation('sclMerlyn');
        $expected->setEmail('example@email.com');
        $expected->setPhone('+44.3344555666');
        $expected->setOptOut(false);
        $expected->setCompanyNumber('5489549');
        $expected->setTradeName('Big enterprises');
        $expected->setType('UNKNOWN');

        $address = new \SclNominetEpp\Address();
        $address->setAddressLineOne('Bryn Seion Chapel');
        $address->setCity('Cardigan');
        $address->setStateProvince('Ceredigion');
        $address->setPostCode('SA43 2HB');
        $address->setCountryCode('US');

        $expected->setAddress($address);

        $this->response->init($xml);

        $contact = $this->response->getContact();

        $this->assertEquals($expected, $contact);

    }
}
