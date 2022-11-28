<?php
namespace SclNominetEpp\Response;

use PHPUnit\Framework\TestCase;
use SclNominetEpp\Response;
use SimpleXMLElement;

/**
 * response error epp command test.
 */
class ErrorTest extends TestCase
{
    protected Response $request;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->request = new Response();
    }

    public function testError()
    {
        $filename = __DIR__ . '/' . pathinfo(__FILE__, PATHINFO_FILENAME) . '.xml';
        $xml = file_get_contents($filename);
        $this->request->init($xml);
        $this->assertEquals(Response::ERROR_COMMAND_SYNTAX, $this->request->code());
        $this->assertEquals('Command syntax error', $this->request->message());
        $this->assertInstanceOf(SimpleXMLElement::class, $this->request->data());
        $this->assertEquals(false, $this->request->success());
    }
}
