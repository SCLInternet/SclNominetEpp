<?php
namespace SclNominetEpp\Response;

use SclNominetEpp\Response;

/**
 * response epp command test.
 */
class ResponseTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Response
     */
    protected $request;

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
        $this->assertEquals([], $this->request->data());
        $this->assertEquals(true, $this->request->success());
    }
}
