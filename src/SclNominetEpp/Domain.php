<?php

namespace SclNominetEpp;

use DateTime;
use DateTimeInterface;
use InvalidArgumentException;

class Domain
{
    const BILL_REGISTRAR = 'th';
    const BILL_CUSTOMER = 'bc';
    const BILLS = [self::BILL_REGISTRAR, self::BILL_CUSTOMER];
    const REGISTRATION_PERIOD = 2;

    /**
     * Domain name
     *
     * @var string
     */
    private $name;

    /**
     * Registration Period
     *
     * @var int
     */
    private $period = self::REGISTRATION_PERIOD;

    /**
     * The Person, Company or Entity who owns or holds a domain name.
     *
     * @var string
     */
    private $registrant;

    /**
     * All the contacts of the registered domain.
     *
     * @var array
     */
    private $contacts = array();

    /**
     * All the nameservers of the registered domain.
     *
     * @var Nameserver[]
     */
    private $nameservers = [];

    /**
     * The identifier of the sponsoring client.
     * Specified in the Nominet EPP as "clID"
     *
     * @var string
     */
    private $clientID;

    /**
     * The identifier of the client that created the domain object.
     * Specified in the Nominet EPP as "crID"
     *
     * @var string
     */
    private $creatorID;

    /**
     * The date and time of domain object creation.
     * Specified in the Nominet EPP as "crDate"
     *
     * @var DateTime
     */
    private $created;

    /**
     * The date and time identifying the end of the domain object's registration period.
     * Specified in the Nominet EPP as "exDate"
     *
     * @var DateTime
     */
    private $expired;

    /**
     * The identifier of the client that last updated the domain object.
     * This variable MUST be null if the domain has never been modified.
     * (could be a name and email address or the value submitted from the <clTRID> element if created by EPP)
     *
     * @var string
     */
    private $upID = null;

    /**
     *
     * The date and time of the most recent domain-object modification, formatted as: YYYYMMDD.
     * This variable MUST be null if the domain object has never been modified.
     *
     * @var DateTime
     */
    private $upDate = null;

    /**
     * If first-bill is not set or set to "th", the registration
     * invoice will be sent to the registrar,
     * setting this to "bc" will instead invoice the customer at the non-member registration rate.
     *
     * @var string
     */
    private $firstBill = self::BILL_REGISTRAR;

    /**
     * If recur-bill is not set or set to "th" invoices for renewals
     * will be sent to the registrar,
     * setting this to "bc" will instead invoice the customer at the non-member renewal rate
     * (the auto-bill and next-bill fields will also be cleared).
     *
     * @var string
     */
    private $recurBill = self::BILL_REGISTRAR;

    /**
     * The number of days before expiry you wish to automatically renew a domain name.
     * Values between 1-182.
     * This field can be cleared by setting the default value of 0.
     * Auto-bill cannot be set if next-bill, recur-bill or renew-not-required are set.
     *
     * @var int
     */
    private $autoBill;

    /**
     * The number of days before expiry you wish to automatically renew a domain name.
     * The next-bill field will reset to 0 after a single registration period.
     * Values between 1 and 182, indicating how many days before expiry you wish to renew the domain name.
     * This field can be cleared by setting the default value of 0.
     * Next-bill cannot be set if auto-bill, recur-bill or renew-not-required are set.
     *
     * @var int
     */
    private $nextBill;

    /**
     * Domain's current registration status
     *
     * @var string
     */
    private $regStatus;

    /**
     * Miscellaneous information relating to the domain name.
     *
     * @var ?string[]
     */
    private $notes;

    /**
     * Password
     *
     * @var string
     */
    private $password;

    public function getRegistrant(): string
    {
        return $this->registrant;
    }

    public function setRegistrant(string $registrant)
    {
        $this->registrant = $registrant;
    }

    /**
     * Set add $contact to array of contacts
     */
    public function addContact(Contact $contact)
    {
        $this->contacts[] = $contact;
    }

    public function getContacts(): array
    {
        return $this->contacts;
    }

    /**
     * Remove $contact from the array of contacts if it already exists.
     *
     * @param Contact $contact
     */
    public function removeContact(Contact $contact)
    {
        $arrayKey = array_search($contact, $this->contacts);
        unset($this->contacts[$arrayKey]);
    }

    /**
     * Add $nameserver to the array of nameservers
     */
    public function addNameserver(Nameserver $nameserver)
    {
        $this->nameservers[] = $nameserver;
    }

    /**
     * Get the array of nameservers
     * @return Nameserver[]
     */
    public function getNameservers(): array
    {
        return $this->nameservers;
    }

    /**
     * Remove $nameserver from the array of namservers if it already exists.
     *
     * @param Nameserver $nameserver
     */
    public function removeNameserver(Nameserver $nameserver)
    {
        $arrayKey = array_search($nameserver, $this->nameservers);
        unset($this->nameservers[$arrayKey]);
    }

    /**
     * Get the identifier of the sponsoring client.
     */
    public function getClientID(): string
    {
        return $this->clientID;
    }

    /**
     * Set the identifier of the sponsoring client.
     */
    public function setClientID(string $clientID)
    {
        $this->clientID = $clientID;
    }

    /**
     * Get the identifier of the client that created the domain object.
     */
    public function getCreatorID(): string
    {
        return $this->creatorID;
    }

    /**
     * Set the identifier of the client that created the domain object.
     */
    public function setCreatorID(string $creatorID)
    {
        $this->creatorID = $creatorID;
    }

    public function getCreated(): DateTime
    {
        return $this->created;
    }

    public function setCreated(DateTime $created)
    {
        $this->created = $created;
    }

    public function getExpired(): DateTime
    {
        return $this->expired;
    }

    public function setExpired(DateTime $expired)
    {
        $this->expired = $expired;
    }

    public function getUpID(): ?string
    {
        return $this->upID;
    }

    public function setUpID(string $upID)
    {
        $this->upID = $upID;
    }

    public function getUpDate()
    {
        return DateTime::createFromFormat(DateTimeInterface::ATOM, $this->upDate);
    }

    public function setUpDate(DateTime $upDate)
    {
        $this->upDate = $upDate->format(DateTimeInterface::ATOM);
    }

    public function getFirstBill(): string
    {
        return $this->firstBill;
    }

    public function setFirstBill(string $firstBill)
    {
        $this->checkBill($firstBill);
        $this->firstBill = $firstBill;
    }

    public function getRecurBill(): string
    {
        return $this->recurBill;
    }

    public function setRecurBill(string $recurBill)
    {
        $this->checkBill($recurBill);
        $this->recurBill = $recurBill;
    }

    public function getAutoBill(): ?int
    {
        return $this->autoBill;
    }

    /**
     * @param int|object $autoBill
     * @return void
     */
    public function setAutoBill($autoBill)
    {
        $this->autoBill = (int) $autoBill;
    }

    public function getNextBill(): ?int
    {
        return $this->nextBill;
    }

    /**
     * @param int|object $nextBill
     * @return void
     */
    public function setNextBill($nextBill)
    {
        $this->nextBill = (int) $nextBill;
    }

    public function getRegStatus(): string
    {
        return $this->regStatus;
    }

    public function setRegStatus(string $regStatus)
    {
        $this->regStatus = $regStatus;
    }

    /**
     * @return ?string[]
     */
    public function getNotes(): ?array
    {
        return $this->notes;
    }

    public function setNotes(array $notes)
    {
        $this->notes = $notes;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getPeriod(): int
    {
        return $this->period;
    }

    /**
     * Set the value of period
     */
    public function setPeriod(int $period): Domain
    {
        if ($period < self::REGISTRATION_PERIOD) {
            $message = sprintf("Invalid period %d, must be greater than %d", $period, self::REGISTRATION_PERIOD);
            throw new InvalidArgumentException($message);
        }
        $this->period = $period;

        return $this;
    }

    protected function checkBill(string $bill): void
    {
        if ($bill === '') {
            return;
        }
        if (in_array($bill, self::BILLS) === false) {
            $options = implode(', ', self::BILLS);
            $message = sprintf("Invalid bill '%s', must one of '%s'", $bill, $options);
            throw new InvalidArgumentException($message);
        }
    }
}
