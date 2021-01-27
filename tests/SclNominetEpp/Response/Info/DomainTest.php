<?php
namespace SclNominetEpp\Response\Info;

use SclNominetEpp\Nameserver;
use DateTime;
use SclNominetEpp\Response\Info\Domain as DomainInfo;

/**
 * domain:info response test
 */
class DomainTest extends \PHPUnit\Framework\TestCase
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
        $this->response = new DomainInfo();
    }

    /**
     *
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
      <domain:infData
        xmlns:domain="urn:ietf:params:xml:ns:domain-1.0"
        xsi:schemaLocation="urn:ietf:params:xml:ns:domain-1.0 domain-1.0.xsd">
        <domain:name>caliban-scl.sch.uk</domain:name>
        <domain:roid>117523-UK</domain:roid>
        <domain:registrant>559D2DD4B2862E89</domain:registrant>
        <domain:ns>
          <domain:hostObj>ns1.caliban-scl.sch.uk.</domain:hostObj>
        </domain:ns>
        <domain:clID>SCL</domain:clID>
        <domain:crID>psamathe@nominet</domain:crID>
        <domain:crDate>2013-01-31T00:11:05</domain:crDate>
        <domain:exDate>2015-01-31T00:11:05</domain:exDate>
      </domain:infData>
    </resData>
    <extension>
      <domain-nom-ext:infData
        xmlns:domain-nom-ext="http://www.nominet.org.uk/epp/xml/domain-nom-ext-1.2"
        xsi:schemaLocation="http://www.nominet.org.uk/epp/xml/domain-nom-ext-1.2 domain-nom-ext-1.2.xsd">
        <domain-nom-ext:reg-status>Registered until expiry date.</domain-nom-ext:reg-status>
        <domain-nom-ext:first-bill>th</domain-nom-ext:first-bill>
        <domain-nom-ext:recur-bill>th</domain-nom-ext:recur-bill>
      </domain-nom-ext:infData>
      <warning:truncated-field field-name="domain:crID"
        xmlns:warning="http://www.nominet.org.uk/epp/xml/std-warning-1.1"
        xsi:schemaLocation="http://www.nominet.org.uk/epp/xml/std-warning-1.1 std-warning-1.1.xsd">
        Full entry is 'psamathe@nominet.org.uk'.
      </warning:truncated-field>
    </extension>
    <trID>
      <clTRID>EPP-SCL</clTRID>
      <svTRID>204085</svTRID>
    </trID>
  </response>
</epp>

EOX;

        $expected = new \SclNominetEpp\Domain();
        $expected->setName('caliban-scl.sch.uk');
        $expected->setRegistrant('559D2DD4B2862E89');
        $expected->setClientID('SCL');
        $expected->setCreatorID('psamathe@nominet');
        $expected->setCreated(new DateTime('2013-01-31T00:11:05'));
        $expected->setExpired(new DateTime('2015-01-31T00:11:05'));
        $expected->setUpID('');
        $expected->setUpDate(new DateTime(''));
        $expected->setFirstBill('th');
        $expected->setRecurBill('th');
        $expected->setAutoBill('');
        $expected->setNextBill('');
        $expected->setRegStatus('Registered until expiry date.');
        $nameserver = new Nameserver();
        $nameserver->setHostName('ns1.caliban-scl.sch.uk.');
        $expected->addNameserver($nameserver);
        // print_r($expected);
        $this->response->init($xml);

        $domain = $this->response->getDomain();
        // print_r($domain);

        $this->assertEquals($expected, $domain);

    }
}
