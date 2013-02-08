<?php
namespace SclNominetEpp\Response;

use SclNominetEpp\Response;

/**
 * response epp command test.
 */
class ResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Response
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Response();
    }

    public function testPrintResponse()
    {

    }
}
