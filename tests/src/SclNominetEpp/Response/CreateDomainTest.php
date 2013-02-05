<?php
namespace SclNominetEpp\Response;

use DateTime;

/**
 */
class CreateDomainTest extends \PHPUnit_Framework_TestCase
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
        $this->response = new CreateDomain();
    }

    /**
     * @covers SclNominetEpp\Response\CreateDomain::processData
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
      <domain:creData
       xmlns:domain="urn:ietf:params:xml:ns:domain-1.0">
        <domain:name>example.com</domain:name>
        <domain:crDate>1999-04-03T22:00:00.0Z</domain:crDate>
        <domain:exDate>2001-04-03T22:00:00.0Z</domain:exDate>
      </domain:creData>
    </resData>
    <trID>
      <clTRID>ABC-12345</clTRID>
      <svTRID>54321-XYZ</svTRID>
    </trID>
  </response>
</epp>

EOX;

        $expected = new \SclNominetEpp\Domain();
        $expected->setName('example.com');
        $expected->setCreated(new DateTime('1999-04-03T22:00:00.0Z'));
        $expected->setExpired(new DateTime('2001-04-03T22:00:00.0Z'));

        $this->response->init($xml);

        $domain = $this->response->getDomain();

        $this->assertEquals($expected, $domain);
    }
}
