<?php

namespace SclNominetEpp\Request;

use SclNominetEpp\Domain;
use SclNominetEpp\Nominet;
use SclNominetEpp\Request\Update\Helper\DomainCompareHelper;

class Update
{
    /**
     * @var Domain
     */
    private $domain;

    /**
     * @var Domain
     */
    private $currentDomain;

    /**
     * @var Update\Domain
     */
    private $request;

    public function __invoke(Domain $domain, Domain $currentDomain): Update\Domain
    {
        $this->domain = $domain;
        $this->currentDomain = $currentDomain;
        $this->request = new Update\Domain($domain->getName());
        $this->request->setDomain($domain);
        $this->nameservers();
        $this->contacts();
        $this->extra();
        return $this->request;
    }

    protected function nameservers(): void
    {
        $currentNameservers = $this->currentDomain->getNameservers();
        $newNameservers = $this->domain->getNameservers();

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
                $this->request->add(new Update\Field\DomainNameserver($nameserver->getHostName()));
            }
        }

        if (!empty($removeNameservers)) {
            foreach ($removeNameservers as $nameserver) {
                $this->request->remove(new Update\Field\DomainNameserver($nameserver->getHostName()));
            }
        }

        if (empty($this->domain->getNameservers())) {
            $this->request->add(new Update\Field\Status('Payment overdue.', Nominet::STATUS_CLIENT_HOLD));
        }
    }

    protected function contacts(): void
    {
        $currentContacts = $this->currentDomain->getContacts();
        $newContacts = $this->domain->getContacts();

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

        if (!empty($addContacts)) {
            foreach ($addContacts as $type => $contact) {
                $this->request->add(new Update\Field\DomainContact($contact->getId(), $type));
            }
        }

        if (!empty($removeContacts)) {
            foreach ($removeContacts as $type => $contact) {
                $this->request->remove(new Update\Field\DomainContact($contact->getId(), $type));
            }
        }
    }

    protected function extra(): void
    {
        if ($this->domain->getRegistrant() !== null &&
            $this->domain->getRegistrant() != $this->currentDomain->getRegistrant()) {
            $this->request->changeRegistrant($this->domain->getRegistrant());
        }

        if ($this->domain->getPassword() !== null &&
            $this->domain->getPassword() != $this->currentDomain->getPassword()) {
            $this->request->changePassword($this->domain->getPassword());
        }

        if ($this->domain->getAutoBill() !== null &&
            $this->domain->getAutoBill() != $this->currentDomain->getAutoBill()) {
            $this->request->setAutoBill($this->domain->getAutoBill());
        }

        if ($this->domain->getNextBill() !== null &&
            $this->domain->getNextBill() != $this->currentDomain->getNextBill()) {
            $this->request->setNextBill($this->domain->getNextBill());
        }

        if ($this->domain->getNotes() !== null &&
            $this->domain->getNotes() != $this->currentDomain->getNotes()) {
            $this->request->setNotes($this->domain->getNotes());
        }
    }
}
