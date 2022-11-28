<?php

namespace SclNominetEpp\Request;

use PHPUnit\Framework\TestCase;
use SclNominetEpp\Domain;
use SclNominetEpp\Nameserver;

class UpdateTest extends TestCase
{
    public function testUpdate()
    {
        $domainName = 'epp-example2.co.uk';
        $currentDomain = new Domain();
        $nameServer = new Nameserver();
        $nameServer->setHostName('ns0.epp-example1.co.uk');
        $currentDomain->addNameserver($nameServer);
        $nameServer = new Nameserver();
        $nameServer->setHostName('ns0.epp-example2.co.uk');
        $currentDomain->addNameserver($nameServer);
        $currentDomain->setRegistrant('123456789');
        $domain = new Domain();
        $domain->setName($domainName);
        $nameServer = new Nameserver();
        $nameServer->setHostName('ns0.epp-example3.co.uk');
        $domain->addNameserver($nameServer);
        $nameServer = new Nameserver();
        $nameServer->setHostName('ns0.epp-example4.co.uk');
        $domain->addNameserver($nameServer);
        $domain->setRegistrant('5689658965');
        $domain->setAutoBill(143);
        $domain->setNextBill(10);
        $domain->setNotes(['notes', 'notes2']);
        $update = new Update();
        $request = $update($domain, $currentDomain);
        $filename = __DIR__ . '/' . pathinfo(__FILE__, PATHINFO_FILENAME) . '.xml';
        $xml = file_get_contents($filename);
        $this->assertEquals($xml, $request->getPacket());
    }
}
