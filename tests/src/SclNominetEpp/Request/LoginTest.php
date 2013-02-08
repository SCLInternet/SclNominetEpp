<?php
namespace SclNominetEpp\Request;

/**
 * login epp command test
 */
class LoginTest extends \PHPUnit_Framework_TestCase
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
        $this->object = new Login();
    }

    public function testLogin()
    {
        $this->object;

        $this->object->setCredentials('TAG', 'PASSWORD');

        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<epp xmlns="urn:ietf:params:xml:ns:epp-1.0"
    xsi:schemaLocation="urn:ietf:params:xml:ns:epp-1.0 epp-1.0.xsd"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
    <command>
        <login>
            <clID>TAG</clID>
            <pw>PASSWORD</pw>
            <options>
                <version>1.0</version>
                <lang>en</lang>
            </options>
            <svcs>
                <objURI>urn:ietf:params:xml:ns:domain-1.0</objURI>
                <objURI>urn:ietf:params:xml:ns:contact-1.0</objURI>
                <objURI>urn:ietf:params:xml:ns:host-1.0</objURI>
                <svcExtension>
                    <extURI>http://www.nominet.org.uk/epp/xml/domain-nom-ext-1.2</extURI>
                    <extURI>http://www.nominet.org.uk/epp/xml/contact-nom-ext-1.0</extURI>
                    <extURI>http://www.nominet.org.uk/epp/xml/std-notifications-1.2</extURI>
                    <extURI>http://www.nominet.org.uk/epp/xml/std-warning-1.1</extURI>
                    <extURI>http://www.nominet.org.uk/epp/xml/std-contact-id-1.0</extURI>
                    <extURI>http://www.nominet.org.uk/epp/xml/std-release-1.0</extURI>
                    <extURI>http://www.nominet.org.uk/epp/xml/std-handshake-1.0</extURI>
                    <extURI>http://www.nominet.org.uk/epp/xml/nom-abuse-feed-1.0</extURI>
                    <extURI>http://www.nominet.org.uk/epp/xml/std-fork-1.0</extURI>
                    <extURI>http://www.nominet.org.uk/epp/xml/std-list-1.0</extURI>
                    <extURI>http://www.nominet.org.uk/epp/xml/std-locks-1.0</extURI>
                    <extURI>http://www.nominet.org.uk/epp/xml/std-unrenew-1.0</extURI>
                </svcExtension>
            </svcs>
        </login>
    </command>
</epp>

EOF;

        //$this->assertEquals($xml, (string) $this->object);

    }
}
