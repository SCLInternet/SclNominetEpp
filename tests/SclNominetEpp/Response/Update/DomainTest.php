<?php
namespace SclNominetEpp\Response\Update;

use DateTime;
use PHPUnit\Framework\TestCase;
use SclNominetEpp\Domain;
use SclNominetEpp\Response\Update\Domain as UpdateDomain;
use SclRequestResponse\ResponseInterface;

/**
 * domain:create response test
 */
class DomainTest extends TestCase
{
    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->response = new UpdateDomain();
    }

    public function testProcessData()
    {
        $expected = new Domain();
        $expected->setName('example.com');
        $expected->setCreated(new DateTime('1999-04-03T22:00:00.0Z'));
        $expected->setExpired(new DateTime('2001-04-03T22:00:00.0Z'));

        $filename = __DIR__ . '/' . pathinfo(__FILE__, PATHINFO_FILENAME) . '.xml';
        $xml = file_get_contents($filename);
        $this->response->init($xml);

        $message = $this->response->message();
        $code = $this->response->code();

        $this->assertEquals('Command completed successfully', $message);
        $this->assertEquals(1000, $code);
    }
}
