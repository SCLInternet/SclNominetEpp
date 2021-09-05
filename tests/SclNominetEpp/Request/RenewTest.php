<?php
namespace SclNominetEpp\Request;

use DateTime;
use PHPUnit\Framework\TestCase;

class RenewTest extends TestCase
{

    public function testRequestException()
    {
        $object = new Renew('example.org.uk');
        $this->expectException(\InvalidArgumentException::class);
        $object->getPacket();
    }

    public function testRequestXML()
    {
        $object = new Renew('example.co.uk');
        $object->setDate(new DateTime('2009-04-07'));
        $filename = __DIR__ . '/' . pathinfo(__FILE__, PATHINFO_FILENAME) . '.xml';
        $xml = file_get_contents($filename);
        $this->assertEquals($xml, $object->getPacket());
    }
}