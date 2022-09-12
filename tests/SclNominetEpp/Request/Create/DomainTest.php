<?php
namespace SclNominetEpp\Request\Create;

use PHPUnit\Framework\TestCase;
use SclNominetEpp\Nameserver;
use SclNominetEpp\Domain;
use SclNominetEpp\Request;
use SclNominetEpp\Request\Create\Domain as CreateDomain;
use DateTime;

/**
 * domain:create test
 */
class DomainTest extends TestCase
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->request = new CreateDomain();
    }

    public function testCreateDomain()
    {
        $domain = new Domain();
        $domain->setName('caliban-scl.sch.uk');
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
        $nameserver->setHostName('ns1.caliban-scl.sch.uk');
        $domain->addNameserver($nameserver);

        $techy = new \SclNominetEpp\Contact();
        $techy->setId('techy1');
        $techy->setType('tech');
        $domain->addContact($techy);
        $admin = new \SclNominetEpp\Contact();
        $admin->setId('admin1');
        $admin->settype('admin');
        $domain->addContact($admin);

        $this->request->setDomain($domain);

        $filename = __DIR__ . '/' . pathinfo(__FILE__, PATHINFO_FILENAME) . '.xml';
        $xml = file_get_contents($filename);
        $this->assertEquals($xml, $this->request->getPacket());
    }
}
