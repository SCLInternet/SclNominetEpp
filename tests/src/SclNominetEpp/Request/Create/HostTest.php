<?php
namespace SclNominetEpp\Request;

use SclNominetEpp\Nameserver;
use SclNominetEpp\Request\Create\Host as CreateHost;
/**
 */
class CreateHostTest extends \PHPUnit_Framework_TestCase
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
        $this->request = new CreateHost();
    }

    public function testCreateHost()
    {
        $xml = <<<EOX
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<epp xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="urn:ietf:params:xml:ns:epp-1.0" xsi:schemaLocation="urn:ietf:params:xml:ns:epp-1.0 epp-1.0.xsd">
  <command>
    <create>
      <host:create xmlns:host="urn:ietf:params:xml:ns:host-1.0">
        <host:name>ns1.example.com.</host:name>
        <host:addr ip="v4">192.0.2.2</host:addr>
        <host:addr ip="v6">1080:0:0:0:8:800:200C:417A</host:addr>
      </host:create>
    </create>
  </command>
</epp>

EOX;

        $host = new Nameserver();
        $host->setHostName('ns1.example.com.');
        $host->setIpv4('192.0.2.2');
        $host->setIpv6('1080:0:0:0:8:800:200C:417A');
        $this->request->setNameserver($host);

        $this->assertEquals($xml, $this->request->getPacket());
    }
}
