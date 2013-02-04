<?php

include __DIR__ . '/../vendor/autoload.php';

if (sizeof($argv) < 2) {
    die("No command given\n");
}

$config = include __DIR__ . '/test_epp.config.php';

$communicator = new \SclNominetEpp\Communicator(new \BasicSocket\Socket);
$communicator->connect($config['live']);

$nominet = new \SclNominetEpp\Nominet();
$nominet->setCommunicator($communicator);

$nominet->login($config['username'], $config['password']);

$command = $argv[1];
unset($argv[0]);
unset($argv[1]);

foreach ($argv as &$arg) {
    if (preg_match('/^\[\[(.+)\]\]$/', $arg, $match))
        $arg = explode(',', $match[1]);
}

$argv = array_values($argv);

switch (strtolower($command)) {
    case 'createdomain':
        $domain = new \SclNominetEpp\Domain();
        $domain->setName($argv[0]);
        $domain->setPeriod(2);
        $domain->addNameserver(new \SclNominetEpp\Nameserver('ns1.caliban-scl.sch.uk.'));
        $domain->setRegistrant('sc2343');
        $techy = new \SclNominetEpp\Contact();
        $techy->setId('tech1');
        $domain->addContact('tech',$techy);
        $admin = new \SclNominetEpp\Contact();
        $admin->setId('admin1');
        $domain->addContact('admin',$admin);
        //$domain->addPassword('qwerty');

	$argv[0] = $domain;
        break;
}

var_dump(call_user_func_array(array($nominet, $command), $argv));
