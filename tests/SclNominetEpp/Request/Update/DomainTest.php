<?php
namespace SclNominetEpp\Request\Update;

use PHPUnit\Framework\TestCase;
use SclNominetEpp\Nominet;
use SclNominetEpp\Request\Update\Domain as UpdateDomain;
use SclNominetEpp\Request\Update\Field\DomainNameserver;
use SclNominetEpp\Request\Update\Field\Status;

class DomainTest extends TestCase
{
    public function testUpdateDomain()
    {
        $domainName = 'epp-example2.co.uk';

        $request = new UpdateDomain($domainName);
        $request->add(new DomainNameserver('ns0.epp-example3.co.uk'));
        $request->add(new DomainNameserver('ns0.epp-example4.co.uk'));
        $request->remove(new DomainNameserver('ns0.epp-example1.co.uk'));
        $request->remove(new DomainNameserver('ns0.epp-example2.co.uk'));
        $contact = new \SclNominetEpp\Contact();
        $contact->setId(5689658965);
        $request->changeRegistrant($contact);
        $request->add(new Status('Payment Overdue', Nominet::STATUS_CLIENT_HOLD));
        $request->setAutoBill(143);
        $request->setNextBill(10);
        $request->addNote('notes');
        $request->addNote('notes2');

        $filename = __DIR__ . '/' . pathinfo(__FILE__, PATHINFO_FILENAME) . '.xml';
        $xml = file_get_contents($filename);
        $this->assertEquals($xml, $request->getPacket());
    }
}
