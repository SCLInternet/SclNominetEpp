<?php
namespace SclNominetEpp\Response;

/**
 */
class CheckContactTest extends \PHPUnit_Framework_TestCase
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
        $this->response = new CheckContact();
    }


    /**
     * @covers SclNominetEpp\Response\CheckContact::processData
     *
     */
    public function testProcessData()
    {

        $xml = <<<EOX
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
  <command>
    <check>
      <contact:check xmlns:contact="urn:ietf:params:xml:ns:contact-1.0">
        <contact:id>sc2343</contact:id>
        <contact:id>sah8013</contact:id>
        <contact:id>8013sah</contact:id>
      </contact:check>
    </check>
    <clTRID>ABC-12345</clTRID>
  </command>
</epp>
EOX;

        $expected = array('sc2343', 'sah8013', '8013sah');

        $this->response->init($xml);

        $contacts = $this->response->getContacts();

        $this->assertEquals($expected, $contacts);

    }
}
