<?php

use \SclNominetEpp\Address;

include __DIR__ . '/../vendor/autoload.php';

if (sizeof($argv) < 2) {
    die("No command given\n");
}

$config = include __DIR__ . '/test_epp.config.php';

$communicator = new \SclNominetEpp\Communicator(new \SclSocket\Socket);
$communicator->connect($config['live']);

$nominet = new \SclNominetEpp\Nominet();
$nominet->setCommunicator($communicator);

$nominet->login($config['username'], $config['password']);

$command = $argv[1];
unset($argv[0]);
unset($argv[1]);

foreach ($argv as &$arg) {
    if (preg_match('/^\[\[(.+)\]\]$/', $arg, $match)) {
        $arg = explode(',', $match[1]);
    }
}

$argv = array_values($argv);

switch (strtolower($command)) {
    case 'createcontact':
        $contact = new \SclNominetEpp\Contact();
        $contact->setId('sc2343');
        $contact->setName('name');
        $contact->setEmail('example@email.com');
        $address = new Address();
        $address->setAddressLineOne('Bryn Seion Chapel');
        $address->setCity('Cardigan');
        $address->setCountryCode('US');
        $address->setStateProvince('Ceredigion');
        $address->setPostCode('SA43 2HB');
        $contact->setAddress($address);
        $contact->setCompanyNumber('NI65786');
        $contact->setPhone('+44.3344555666');
        $contact->setOrganisation('sclMerlyn');
        $contact->setFax('+443344555616');
        $contact->setOptOut('y');
        $argv[0] = $contact;
        break;
    case 'createdomain':
        $domain = new \SclNominetEpp\Domain();
        $domain->setName($argv[0]);
        $domain->setPeriod(2);
        $nameserver = new \SclNominetEpp\Nameserver();
        $nameserver->setHostName('ns1.caliban-scl.sch.uk.');
        $domain->addNameserver($nameserver);
        $domain->setRegistrant('sc2343');
        $techy = new \SclNominetEpp\Contact();
        $techy->setId('tech1');
        $techy->setType('tech');
        $domain->addContact($techy);
        $admin = new \SclNominetEpp\Contact();
        $admin->setId('admin1');
        $admin->settype('admin');
        //$domain->addPassword('qwerty');

        $argv[0] = $domain;
        break;
    case 'createhost':
        $host = new \SclNominetEpp\Nameserver();
        $host->setHostName('ns1.example.com.');
        $host->setIpv4('192.0.2.2');
        $host->setIpv6('1080:0:0:0:8:800:200C:417A');
        $argv[0] = $host;
        break;
    case 'updatedomain':
        $domain = new \SclNominetEpp\Domain();
        $domain->setName($argv[0]);
        $domain->setPeriod(2);
        $nameserver = new \SclNominetEpp\Nameserver();
        $nameserver->setHostName('ns1.example.com.');
        $domain->addNameserver($nameserver);
        $nameserver2 = new \SclNominetEpp\Nameserver();
        $nameserver2->setHostName('ns3.example.com.');
        $domain->addNameserver($nameserver2);
        
        $domain->setRegistrant('sc2343');
        $techy = new \SclNominetEpp\Contact();
        $techy->setId('tech1');
        $techy->setType('tech');
        $domain->addContact($techy);
        $admin = new \SclNominetEpp\Contact();
        $admin->setId('admin1');
        $admin->settype('admin');
        $domain->addContact($admin);
        $admin2 = new \SclNominetEpp\Contact();
        $admin2->setId('admin2');
        $admin2->setType('admin');
        $domain->addContact($admin2);
}

var_dump(call_user_func_array(array($nominet, $command), $argv));
