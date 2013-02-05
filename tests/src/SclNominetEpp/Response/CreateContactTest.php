<?php
namespace SclNominetEpp\Response;

use DateTime;

class CreateContactTest extends \PHPUnit_Framework_TestCase
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
        $this->response = new CreateContact();
    }

    /**
     * @covers SclNominetEpp\Response\HostInfo::processData
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
      <contact:creData xmlns:contact="urn:ietf:params:xml:ns:contact-1.0">
        <contact:id>sc2343</contact:id>
        <contact:crDate>2013-01-31T00:11:05</contact:crDate>
      </contact:creData>
    </resData>
    <trID>
      <clTRID>ABC-12345</clTRID>
      <svTRID>54321-XYZ</svTRID>
    </trID>
  </response>
</epp>

EOX;

        $expected = new \SclNominetEpp\Contact();
        $expected->setId('sc2343');
        $expected->setCreated(new DateTime('2013-01-31T00:11:05'));

        $this->response->init($xml);

        $host = $this->response->getContact();

        $this->assertEquals($expected, $host);
    }
}
