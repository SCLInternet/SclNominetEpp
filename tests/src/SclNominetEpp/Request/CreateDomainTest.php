<?php
namespace SclNominetEpp\Request;

use SclNominetEpp\Contact;
use SclNominetEpp\Nameserver;
use DateTime;

/**
 */
class CreateDomainTest extends \PHPUnit_Framework_TestCase
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
        $this->request = new CreateDomain();
    }


    /**
     * @covers SclNominetEpp\Request\CreateDomain::testCreateDomain
     * @todo   Implement test__toString().
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

        $domain = new \SclNominetEpp\Domain();
        $domain->setName('caliban-scl.sch.uk');
        $domain->setRegistrant('559D2DD4B2862E89');
        $domain->setClientID('SCL');
        $domain->setCreatorID('psamathe@nominet');
        $domain->setCreated(new DateTime('2013-01-31T00:11:05'));
        $domain->setExpired(new DateTime('2015-01-31T00:11:05'));
        $domain->setUpID('');
        $domain->setUpDate(new DateTime(''));
        $domain->setFirstBill('th');
        $domain->setRecurBill('th');
        $domain->setAutoBill('');
        $domain->setNextBill('');
        $domain->setRegStatus('Registered until expiry date.');
        $domain->addNameserver(new Nameserver('ns1.caliban-scl.sch.uk.'));

        $tech  = new Contact();
        $tech->setId('techy1');
        $admin = new Contact();
        $admin->setId('admin1');

        $domain->addContact('tech', $tech);
        $domain->addContact('admin', $admin);



        $this->request->setDomain($domain);

                $this->assertEquals($xml, (string)$this->request);
    }
}
