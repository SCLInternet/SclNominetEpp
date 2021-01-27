<?php
namespace SclNominetEpp\Request\Check;

use SclNominetEpp\Request;
use SclNominetEpp\Request\Check\Host as CheckHost;

/**
 * host:check test
 */
class HostTest extends \PHPUnit\Framework\TestCase
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
        $this->request = new CheckHost();
    }

    public function testProcessData()
    {
                $xml = <<<EOX
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<epp xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="urn:ietf:params:xml:ns:epp-1.0" xsi:schemaLocation="urn:ietf:params:xml:ns:epp-1.0 epp-1.0.xsd">
  <command>
    <check>
      <host:check xmlns:host="urn:ietf:params:xml:ns:host-1.0">
        <host:name>ns1.example.com</host:name>
        <host:name>ns2.example.com</host:name>
        <host:name>ns3.example.com</host:name>
      </host:check>
    </check>
  </command>
</epp>

EOX;

        $hosts = array('ns1.example.com','ns2.example.com', 'ns3.example.com');
        $this->request->lookup($hosts);

        $this->assertEquals($xml, $this->request->getPacket());
    }
}
