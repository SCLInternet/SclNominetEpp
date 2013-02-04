<?php
namespace SclNominetEpp\Response;

/**
 */
class CheckDomainTest extends \PHPUnit_Framework_TestCase
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
        $this->response = new CheckDomain();
    }


    /**
     * @covers SclNominetEpp\Response\CheckDomain::processData
     *
     */
    public function testProcessData()
    {

        $xml = <<<EOX
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<epp xmlns="urn:ietf:params:xml:ns:epp-1.0"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.nominet.org.uk/epp/xml/epp-1.0 epp-1.0.xsd">
  <response>
    <result code="1000">
      <msg>Command completed successfully</msg>
    </result>
    <resData>
      <domain:chkData
        xmlns:domain="urn:ietf:params:xml:ns:domain-1.0"
        xsi:schemaLocation="urn:ietf:params:xml:ns:domain-1.0 domain-1.0.xsd">
        <domain:cd>
          <domain:name avail="0">domain1.co.uk</domain:name>
        </domain:cd>
        <domain:cd>
          <domain:name avail="1">domain2.co.uk</domain:name>
        </domain:cd>
      </domain:chkData>
    </resData>
    <extension>
      <domain-nom-ext:chkData abuse-limit="49993"
        xmlns:domain-nom-ext="http://www.nominet.org.uk/epp/xml/domain-nom-ext-1.2"
        xsi:schemaLocation="http://www.nominet.org.uk/epp/xml/domain-nom-ext-1.2 domain-nom-ext-1.2.xsd"/>
    </extension>
    <trID>
      <clTRID>EPP-SCL</clTRID>
      <svTRID>241300</svTRID>
    </trID>
  </response>
</epp>
EOX;

        $expected = array(
            'domain1.co.uk' => false,
            'domain2.co.uk' => true,
        );

        $this->response->init(new \SimpleXMLElement($xml));

        $domains = $this->response->getDomains();

        $this->assertEquals($expected, $domains);

    }
}
