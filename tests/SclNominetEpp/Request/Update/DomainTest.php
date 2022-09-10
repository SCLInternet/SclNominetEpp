<?php
namespace SclNominetEpp\Request\Update;

use PHPUnit\Framework\TestCase;
use SclNominetEpp\Nameserver;
use SclNominetEpp\Domain;
use SclNominetEpp\Request;
use SclNominetEpp\Request\Update\Domain as UpdateDomain;
use DateTime;

class DomainTest extends TestCase
{
    public function testUpdateDomain()
    {
        $domainName = 'epp-example2.co.uk';
        $domain = new Domain();
        $domain->setName($domainName);
        $domain->setRegistrant('559D2DD4B2862E89');
        $domain->setClientID('SCL');
        $domain->setCreatorID('psamathe@nominet');
        $domain->setCreated(new DateTime('2013-01-31T00:11:05'));
        $domain->setExpired(new DateTime('2015-01-31T00:11:05'));
        $domain->setUpID('');
        $domain->setUpDate(new DateTime(''));
        $domain->setFirstBill(Domain::BILL_REGISTRAR);
        $domain->setRecurBill(Domain::BILL_REGISTRAR);
        $domain->setAutoBill(0);
        $domain->setNextBill(0);
        $domain->setRegStatus('Registered until expiry date.');
        $nameserver = new Nameserver();
        $nameserver->setHostName('ns0.epp-example3.co.uk.');
        $domain->addNameserver($nameserver);
        $nameserver = new Nameserver();
        $nameserver->setHostName('ns0.epp-example4.co.uk.');
        $domain->addNameserver($nameserver);

        $techy = new \SclNominetEpp\Contact();
        $techy->setId('techy1');
        $techy->setType('tech');
        $domain->addContact($techy);
        $admin = new \SclNominetEpp\Contact();
        $admin->setId('admin1');
        $admin->settype('admin');
        $domain->addContact($admin);

        $request = new UpdateDomain($domain);

        $filename = __DIR__ . '/' . pathinfo(__FILE__, PATHINFO_FILENAME) . '.xml';
        $xml = file_get_contents($filename);
        $this->assertEquals($xml, $request->getPacket());
    }
}
