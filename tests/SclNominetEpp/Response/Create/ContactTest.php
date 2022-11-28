<?php
namespace SclNominetEpp\Response\Create;

use DateTime;
use SclNominetEpp\Contact;
use SclNominetEpp\Response\Create\Contact as CreateContact;

/**
 * contact:create response test
 */
class ContactTest extends \PHPUnit\Framework\TestCase
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
        $this->response = new CreateContact();
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

        $expected = new Contact();
        $expected->setId('sc2343');
        $expected->setCreated(new DateTime('2013-01-31T00:11:05'));

        $this->response->init($xml);

        $host = $this->response->getObject();

        $this->assertEquals($expected, $host);
    }
}
