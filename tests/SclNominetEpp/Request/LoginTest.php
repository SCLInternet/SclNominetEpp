<?php
namespace SclNominetEpp\Request;

use PHPUnit\Framework\TestCase;
use SclNominetEpp\Request;

/**
 * login epp command test
 */
class LoginTest extends TestCase
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
        $this->request = new Login();
    }

    public function testLogin()
    {
        $this->request;

        $this->request->setCredentials('TAG', 'PASSWORD');

        $filename = __DIR__ . '/' . pathinfo(__FILE__, PATHINFO_FILENAME) . '.xml';
        $xml = file_get_contents($filename);
        $this->assertEquals($xml, $this->request->getPacket());

    }
}
