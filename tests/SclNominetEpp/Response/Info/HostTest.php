<?php
namespace SclNominetEpp\Response\Info;

use PHPUnit\Framework\TestCase;
use SclNominetEpp\Nameserver;
use DateTime;
use SclNominetEpp\Response;
use SclNominetEpp\Response\Info\Host as HostInfo;

/**
 * host:info response test
 */
class HostTest extends TestCase
{
    /**
     * @var Response
     */
    protected $response;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->response = new HostInfo();
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
      <host:infData
        xmlns:host="urn:ietf:params:xml:ns:host-1.0"
        xsi:schemaLocation="urn:ietf:params:xml:ns:host-1.0 host-1.0.xsd">
        <host:name>ns1.caliban-scl.sch.uk</host:name>
        <host:roid>739787E8A10BF2CA11882CE974FD775E-UK</host:roid>
        <host:status s="ok"/>
        <host:status s="linked"/>
        <host:addr ip="v4">1.2.3.4</host:addr>
        <host:clID>UNKNOWN</host:clID>
        <host:crID>NOMINET</host:crID>
        <host:crDate>2013-01-31T00:11:05</host:crDate>
      </host:infData>
    </resData>
    <trID>
      <clTRID>EPP-SCL</clTRID>
      <svTRID>228776</svTRID>
    </trID>
  </response>
</epp>

EOX;

        $expected = new Nameserver();
        $expected->setHostName('ns1.caliban-scl.sch.uk');
        $expected->addStatus('ok');
        $expected->addStatus('linked');
        $expected->setIpv4('1.2.3.4');
        $expected->setClientID('UNKNOWN');
        $expected->setCreatorID('NOMINET');
        $expected->setCreated(new DateTime('2013-01-31T00:11:05'));
        $expected->setUpDate(new DateTime(''));
        $expected->setId('739787E8A10BF2CA11882CE974FD775E-UK');

        $this->response->init($xml);

        $host = $this->response->getHost();

        $this->assertEquals($expected, $host);
    }
}
