<?php
namespace SclNominetEpp\Request;

use SclNominetEpp\Contact;
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
      <domain:create xmlns:domain="urn:ietf:params:xml:ns:domain-1.0">
        <domain:name>caliban-scl.sch.uk</domain:name>
        <domain:period unit="y">2</domain:period>
        <domain:ns>
          <domain:hostObj>ns1.caliban-scl.sch.uk.</domain:hostObj>
        </domain:ns>
        <domain:registrant>559D2DD4B2862E89</domain:registrant>
        <domain:contact type="tech">techy1</domain:contact>
        <domain:contact type="admin">admin1</domain:contact>
        <domain:authInfo>
          <domain:pw>qwerty</domain:pw>
        </domain:authInfo>
      </domain:create>
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
        $address = new Address('Bryn Seion Chapel', 'Cardigan', 'US', null, null, 'Ceredigion', 'SA43 2HB');
        $contact->setAddress($address);

        $contact->setCompanyNumber('NI65786');
        // The registered company number or the DfES UK school number of the registrant.
        $contact->setPhone('+44.3344555666');
        $contact->setOrg('sclMerlyn');
        $contact->setFax('+443344555616');
        $contact->setOptOut('y');

   
        

        
        $this->request->setContact($contact);

                $this->assertEquals($xml, (string)$this->request);
    }
}
