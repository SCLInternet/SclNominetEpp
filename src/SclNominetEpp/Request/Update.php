<?php

namespace SclNominetEpp\Request;

use DomainException;
use SclNominetEpp\Domain;
use SclNominetEpp\Request\Update\Helper\DomainCompareHelper;

class Update
{
    public function __invoke($domain, $currentDomain): Update\Domain
    {
        $request = new Update\Domain($domain->getName());
        $request->setDomain($domain);

        if (!$currentDomain instanceof Domain) {
            throw new DomainException("The domain requested for updating is unregistered.");
        }
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

        //$request->add(new Update\Field\Status('Payment Overdue', self::STATUS_CLIENT_HOLD));

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
        return $request;
    }
}
