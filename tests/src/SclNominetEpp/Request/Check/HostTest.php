<?php
namespace SclNominetEpp\Request;

use SclNominetEpp\Request\Check\Host as CheckHost;
use SclNominetEpp\Nameserver;

/**
 * host:check test
 */
class HostTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Request
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new CheckHost();
    }

    public function testProcessData()
    {
                $xml = <<<EOX
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
  <command>
    <check>
      <host:check
       xmlns:host="urn:ietf:params:xml:ns:host-1.0">
        <host:name>ns1.example.com</host:name>
        <host:name>ns2.example.com</host:name>
        <host:name>ns3.example.com</host:name>
      </host:check>
    </check>
    <clTRID>ABC-12345</clTRID>
  </command>
</epp>
EOX;
    }
}
