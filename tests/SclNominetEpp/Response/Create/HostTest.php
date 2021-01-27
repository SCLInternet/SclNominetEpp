<?php
namespace SclNominetEpp\Response\Create;

use DateTime;

use SclNominetEpp\Response\Create\Host as CreateHost;


/**
 * host:create response test
 */
class HostTest extends \PHPUnit_Framework_TestCase
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
        $this->response = new CreateHost();
    }

    /**
     *
     *
     */
    public function testProcessData()
    {
        $xml = <<<EOX
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
  <response>
    <result code="1000">
      <msg>Command completed successfully</msg>
    </result>
    <resData>
      <host:creData
       xmlns:host="urn:ietf:params:xml:ns:host-1.0">
        <host:name>ns1.caliban-scl.sch.uk.</host:name>
        <host:crDate>2013-01-31T00:11:05</host:crDate>
      </host:creData>
    </resData>
    <trID>
      <clTRID>ABC-12345</clTRID>
      <svTRID>54322-XYZ</svTRID>
    </trID>
  </response>
</epp>

EOX;

        $expected = new \SclNominetEpp\Nameserver();
        $expected->setHostName('ns1.caliban-scl.sch.uk.');
        $expected->setCreated(new DateTime('2013-01-31T00:11:05'));

        $this->response->init($xml);

        $host = $this->response->getObject();

        $this->assertEquals($expected, $host);

    }
}
