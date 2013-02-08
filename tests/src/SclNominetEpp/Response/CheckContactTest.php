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
  <response>
    <result code="1000">
      <msg>Command completed successfully</msg>
    </result>
    <resData>
      <contact:chkData
       xmlns:contact="urn:ietf:params:xml:ns:contact-1.0">
        <contact:cd>
          <contact:id avail="1">sc2343</contact:id>
        </contact:cd>
        <contact:cd>
          <contact:id avail="0">sah8013</contact:id>
          <contact:reason>In use</contact:reason>
        </contact:cd>
        <contact:cd>
          <contact:id avail="1">8013sah</contact:id>
        </contact:cd>
      </contact:chkData>
    </resData>
    <trID>
      <clTRID>ABC-12345</clTRID>
      <svTRID>54322-XYZ</svTRID>
    </trID>
  </response>
</epp>
EOX;

        $expected = array(
            'sc2343' => true, 
            'sah8013' => false, 
            '8013sah' => true
        );

        $this->response->init($xml);

        $contacts = $this->response->getContacts();

        $this->assertEquals($expected, $contacts);

    }
}
