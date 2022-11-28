<?php
namespace SclNominetEpp\Response;

use PHPUnit\Framework\TestCase;
use SclNominetEpp\Response;
use SimpleXMLElement;

/**
 * response epp command test.
 */
class ResponseTest extends TestCase
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

    public function testPrintResponse()
    {
        $filename = __DIR__ . '/' . pathinfo(__FILE__, PATHINFO_FILENAME) . '.xml';
        $xml = file_get_contents($filename);
        $this->request->init($xml);
        $this->assertEquals(1000, $this->request->code());
        $this->assertEquals("Command completed successfully", $this->request->message());
        $this->assertInstanceOf(SimpleXMLElement::class, $this->request->data());
        $this->assertEquals(true, $this->request->success());
    }
}
