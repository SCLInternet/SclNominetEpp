<?php
namespace SclNominetEpp\Request;

use SclNominetEpp\Response\CheckDomain as CheckDomainResponse;

/**
 */
class CheckDomainTest extends \PHPUnit_Framework_TestCase
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
        $this->request = new AbstractCheck('domain', new CheckDomainResponse(), 'urn:ietf:params:xml:ns:domain-1.0', 'name');
    }

    public function testProcessData()
    {
        $xml = <<<EOX
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<epp xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="urn:ietf:params:xml:ns:epp-1.0" xsi:schemaLocation="urn:ietf:params:xml:ns:epp-1.0 epp-1.0.xsd">
  <command>
    <check>
      <domain:check xmlns:domain="urn:ietf:params:xml:ns:domain-1.0">
        <domain:name>caliban-scl.sch.uk</domain:name>
      </domain:check>
    </check>
  </command>
</epp>

EOX;
        
        $check = $xml->addChild("{$this->type}:check", '', $this->checkNamespace);

        foreach ($this->values as $value) {
            $check->addChild($this->valueName, $value, $this->checkNamespace);
        }
        
        $this->request->setDomains($domains);

        $this->assertEquals($xml, $this->request->getPacket());
    }
}
