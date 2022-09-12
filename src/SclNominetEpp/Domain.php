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
     */
    private string $name;

    /**
     * Registration Period
     */
    private int $period = self::REGISTRATION_PERIOD;

    /**
     * The Person, Company or Entity who owns or holds a domain name.
     */
    private ?string $registrant;

    /**
     * All the contacts of the registered domain.
     *
     * @var Contact[]
     */
    private array $contacts = [];

    /**
     * All the nameservers of the registered domain.
     *
     * @var Nameserver[]
     */
    private array $nameservers = [];

    /**
     * The identifier of the sponsoring client.
     * Specified in the Nominet EPP as "clID"
     */
    private string $clientID;

    /**
     * The identifier of the client that created the domain object.
     * Specified in the Nominet EPP as "crID"
     */
    private string $creatorID;

    /**
     * The date and time of domain object creation.
     * Specified in the Nominet EPP as "crDate"
     */
    private DateTime $created;

    /**
     * The date and time identifying the end of the domain object's registration period.
     * Specified in the Nominet EPP as "exDate"
     */
    private DateTime $expired;

    /**
     * The identifier of the client that last updated the domain object.
     * This variable MUST be null if the domain has never been modified.
     * (could be a name and email address or the value submitted from the <clTRID> element if created by EPP)
     */
    private ?string $upID = null;

    /**
     *
     * The date and time of the most recent domain-object modification, formatted as: YYYYMMDD.
     * This variable MUST be null if the domain object has never been modified.
     */
    private ?DateTime $upDate = null;

    /**
     * If first-bill is not set or set to "th", the registration
     * invoice will be sent to the registrar,
     * setting this to "bc" will instead invoice the customer at the non-member registration rate.
     */
    private string $firstBill = self::BILL_REGISTRAR;

    /**
     * If recur-bill is not set or set to "th" invoices for renewals
     * will be sent to the registrar,
     * setting this to "bc" will instead invoice the customer at the non-member renewal rate
     * (the auto-bill and next-bill fields will also be cleared).
     */
    private string $recurBill = self::BILL_REGISTRAR;

    /**
     * The number of days before expiry you wish to automatically renew a domain name.
     * Values between 1-182.
     * This field can be cleared by setting the default value of 0.
     * Auto-bill cannot be set if next-bill, recur-bill or renew-not-required are set.
     */
    private int $autoBill;

    /**
     * The number of days before expiry you wish to automatically renew a domain name.
     * The next-bill field will reset to 0 after a single registration period.
     * Values between 1 and 182, indicating how many days before expiry you wish to renew the domain name.
     * This field can be cleared by setting the default value of 0.
     * Next-bill cannot be set if auto-bill, recur-bill or renew-not-required are set.
     */
    private int $nextBill;

    /**
     * Domain's current registration status
     */
    private string $regStatus;

    /**
     * Miscellaneous information relating to the domain name.
     *
     * @var ?string[]
     */
    private ?array $notes;

    /**
     * Password
     */
    private string $password;

    /**
     * Set add $contact to array of contacts
     */
    public function addContact(Contact $contact)
    {
        $this->contacts[] = $contact;
    }

    /**
     * Remove $contact from the array of contacts if it already exists.
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
     * Remove $nameserver from the array of nameservers if it already exists.
     */
    public function removeNameserver(Nameserver $nameserver)
    {
        $arrayKey = array_search($nameserver, $this->nameservers);
        unset($this->nameservers[$arrayKey]);
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
        if (filter_var($name, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME) === false) {
            throw new InvalidArgumentException(sprintf('Name parameter "%s" is invalid', $name));
        }
        $this->name = $name;
    }

    public function __toArray(): array
    {
        $data = [];
        $data['name'] = $this->getName();
        $data['period'] = $this->getPeriod();
        $data['registrant'] = $this->getRegistrant();
        $data['contacts'] = $this->getContacts();
        $data['nameservers'] = $this->getNameservers();
        $data['clientID'] = $this->getClientID();
        $data['creatorID'] = $this->getCreatorID();
        $data['created'] = $this->getCreated();
        $data['expired'] = $this->getExpired();
        $data['upID'] = $this->getUpID();
        $data['upDate'] = $this->getUpDate();
        $data['firstBill'] = $this->getFirstBill();
        $data['recurBill'] = $this->getRecurBill();
        $data['autoBill'] = $this->getAutoBill();
        $data['nextBill'] = $this->getNextBill();
        $data['regStatus'] = $this->getRegStatus();
        $data['notes'] = $this->getNotes();
        $data['password'] = $this->getPassword();
        return $data;
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

    public function getRegistrant(): ?string
    {
        return $this->registrant;
    }

    public function setRegistrant(?string $registrant)
    {
        $this->registrant = $registrant;
    }

    /**
     * @return Contact[]
     */
    public function getContacts(): array
    {
        return $this->contacts;
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
        $this->upDate = $upDate;
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
        $this->autoBill = (int)$autoBill;
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
        $this->nextBill = (int)$nextBill;
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
}
