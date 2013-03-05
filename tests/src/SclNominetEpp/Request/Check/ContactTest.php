<?php
namespace SclNominetEpp\Request\Check;

use SclNominetEpp\Contact;
use SclNominetEpp\Request\Check\Contact as CheckContact;
use SclNominetEpp\Response;

/**
 * contact:check test
 */
class ContactTest extends \PHPUnit_Framework_TestCase
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
        $this->request = new CheckContact();
    }

    public function testProcessData()
    {
        $xml = <<<EOX
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<epp xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="urn:ietf:params:xml:ns:epp-1.0" xsi:schemaLocation="urn:ietf:params:xml:ns:epp-1.0 epp-1.0.xsd">
  <command>
    <check>
      <contact:check xmlns:contact="urn:ietf:params:xml:ns:contact-1.0">
        <contact:id>sc2343</contact:id>
        <contact:id>sah8013</contact:id>
        <contact:id>8013sah</contact:id>
      </contact:check>
    </check>
  </command>
</epp>

EOX;

        $contacts = array('sc2343','sah8013', '8013sah');
        $this->request->lookup($contacts);

        $this->assertEquals($xml, $this->request->getPacket());
    }
}
