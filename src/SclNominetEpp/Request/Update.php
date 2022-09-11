<?php

namespace SclNominetEpp\Request;

use SclNominetEpp\Domain;
use SclNominetEpp\Nominet;
use SclNominetEpp\Request\Update\Helper\DomainCompareHelper;

class Update
{
    public function __invoke(Domain $domain, Domain $currentDomain): Update\Domain
    {
        $request = new Update\Domain($domain->getName());
        $request->setDomain($domain);

        $currentNameservers = $currentDomain->getNameservers();
        $currentContacts = $currentDomain->getContacts();
        $newNameservers = $domain->getNameservers();
        $newContacts = $domain->getContacts();

        $addContacts = array_uintersect(
            $newContacts,
            $currentContacts,
            [DomainCompareHelper::class, 'compare']
        );
        $removeContacts = array_uintersect(
            $currentContacts,
            $newContacts,
            [DomainCompareHelper::class, 'compare']
        );
        $addNameservers = array_uintersect(
            $newNameservers,
            $currentNameservers,
            [DomainCompareHelper::class, 'compare']
        );
        $removeNameservers = array_uintersect(
            $currentNameservers,
            $newNameservers,
            [DomainCompareHelper::class, 'compare']
        );

        if (!empty($addNameservers)) {
            foreach ($addNameservers as $nameserver) {
                $request->add(new Update\Field\DomainNameserver($nameserver->getHostName()));
            }
        }

        if (!empty($addContacts)) {
            foreach ($addContacts as $type => $contact) {
                $request->add(new Update\Field\DomainContact($contact->getId(), $type));
            }
        }

        if (!empty($removeNameservers)) {
            foreach ($removeNameservers as $nameserver) {
                $request->remove(new Update\Field\DomainNameserver($nameserver->getHostName()));
            }
        }

        if (!empty($removeContacts)) {
            foreach ($removeContacts as $type => $contact) {
                $request->remove(new Update\Field\DomainContact($contact->getId(), $type));
            }
        }

        if (empty($domain->getNameservers())) {
            $request->add(new Update\Field\Status('Payment overdue.', Nominet::STATUS_CLIENT_HOLD));
        }

        if ($domain->getRegistrant() !== null &&
            $domain->getRegistrant() != $currentDomain->getRegistrant()) {
            $request->changeRegistrant($domain->getRegistrant());
        }

        if ($domain->getPassword() !== null &&
            $domain->getPassword() != $currentDomain->getPassword()) {
            $request->changePassword($domain->getPassword());
        }

        if ($domain->getAutoBill() !== null &&
            $domain->getAutoBill() != $currentDomain->getAutoBill()) {
            $request->setAutoBill($domain->getAutoBill());
        }

        if ($domain->getNextBill() !== null &&
            $domain->getNextBill() != $currentDomain->getNextBill()) {
            $request->setNextBill($domain->getNextBill());
        }

        if ($domain->getNotes() !== null &&
            $domain->getNotes() != $currentDomain->getNotes()) {
            $request->setNotes($domain->getNotes());
        }

        return $request;
    }
}
