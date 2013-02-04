NOMINET EPP IMPLEMENTATION
==========================

Introduction
------------

This is Zend Framework 2 ready module which provides an interface to Nominet's
EPP management API.

Installation
------------

Use composer.phar


Configuration
-------------

Set your tag and password and call it.


Usage
-----

$nominet = $serviceManager->get('SclNominetEPP\Nominet');

$nominet->register(...);
