<?php

namespace SclNominetEpp;

use DateTime;

/**
 * A domain record
 * 
 * @author Tom Oram <tom@scl.co.uk>
 */
class Domain
{
        //BILLS
    const BILL_REGISTRAR = 'th';

    const BILL_CUSTOMER  = 'bc';

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
    private $period = 2;

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
     * @var array
     */
    private $nameservers = array();

    /**
     *
     * @var string
     */
    private $clientID;

    /**
     * 
     * @var string
     */
    private $creatorID;

    /**
     * createdDate
     *
     * @var DateTime
     */
    private $created;

    /**
     * expiredDate
     *
     * @var DateTime
     */
    private $expired;

    /**
     *
     * @var type
     */
    private $upID;

    /**
     *
     * @var type
     */
    private $upDate;

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
     * @var string
     */
    private $notes;

    /**
     * Password
     *
     * @var string
     */
    private $password;

    /**
     * Set the value of period
     *
     * @param  integer $period Must be 2
     * @return Domain
     */
    public function setPeriod($period)
    {
        if (2 !== $period) {
            throw new \Exception("Invalid period $period.");
        }
        $this->period = $period;

        return $this;
    }

    /**
     * Set $this->name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = (string) $name;
    }

    /**
     * Get $this->name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set $this->registrant
     *
     * @param string $registrant
     */
    public function setRegistrant($registrant)
    {
        $this->registrant = (string) $registrant;
    }

    /**
     * Get $this->registrant
     *
     * @return string
     */
    public function getRegistrant()
    {
        return $this->registrant;
    }

    /**
     * Set add $contact to array of contacts
     * 
     * @param \SclNominetEpp\Contact $contact
     */
    public function addContact(Contact $contact)
    {
        $this->contacts[] = $contact;
    }

    /**
     * Get $this->contacts
     *
     * @return array
     */
    public function getContacts()
    {
        return $this->contacts;
    }
    
    /**
     * Remove $contact from the array of contacts if it already exists.
     * 
     * @param \SclNominetEpp\Contact $contact
     */
    public function removeContact(Contact $contact)
    {
        $arrayKey =  array_search($contact, $this->contacts);
        unset($this->contacts[$arrayKey]);
    }

    /**
     * Add $nameserver to the array of nameservers
     *
     * @param Nameserver $nameserver
     */
    public function addNameserver(Nameserver $nameserver)
    {
        $this->nameservers[] = $nameserver;
    }

    /**
     * Get the array $this->nameservers
     * 
     * @return array
     */
    public function getNameservers()
    {
        return $this->nameservers;
    }

    /**
     * Remove $namserver from the array of namservers if it already exists.
     * 
     * @param \SclNominetEpp\Nameserver $nameserver
     */
    public function removeNameserver(Nameserver $nameserver)
    {
        $arrayKey =  array_search($nameserver, $this->nameservers);
        unset($this->nameservers[$arrayKey]);
    }
    /**
     *
     * @param string $clientID
     */
    public function setClientID($clientID)
    {
        $this->clientID = (string) $clientID;
    }

    /**
     *
     * @return string
     */
    public function getClientID()
    {
        return $this->clientID;
    }

    /**
     * Set $this->creatorID
     *
     * @param string $creatorID
     */
    public function setCreatorID($creatorID)
    {
        $this->creatorID = (string) $creatorID;
    }

    /**
     * Get $this->creatorID
     *
     * @return string
     */
    public function getCreatorID()
    {
        return $this->creatorID;
    }
    /**
     * Set $this->created
     *
     * @param DateTime $created
     */
    public function setCreated(DateTime $created)
    {
        $this->created = $created;
    }

    /**
     * Get $this->created
     *
     * @return DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set $this->expired
     *
     * @param DateTime $expired
     */
    public function setExpired(DateTime $expired)
    {
        $this->expired = $expired;
    }

    /**
     * Get $this->expired
     *
     * @return DateTime
     */
    public function getExpired()
    {
        return $this->expired;
    }

    /**
     * Set $this->upID
     *
     * @param string $upID
     */
    public function setUpID($upID)
    {
        $this->upID = (string) $upID;
    }

    /**
     * Get $this->upID
     *
     * @return string
     */
    public function getUpID()
    {
        return $this->upID;
    }

    /**
     * Set $this->upDate
     *
     * @param DateTime $upDate
     */
    public function setUpDate(DateTime $upDate)
    {
        $this->upDate = $upDate;
    }

    /**
     * Get $this->upDate
     *
     * @return DateTime
     */
    public function getUpDate()
    {
        return $this->upDate;
    }

    /**
     * Set $this->firstBill
     *
     * @param string $firstBill
     */
    public function setFirstBill($firstBill)
    {
        $this->firstBill = (string) $firstBill;
    }

    /**
     * Get $this->firstBill
     *
     * @return string
     */
    public function getFirstBill()
    {
        return $this->firstBill;
    }

    /**
     * Set $this->recurBill
     *
     * @param string $recurBill
     */
    public function setRecurBill($recurBill)
    {
        $this->recurBill = (string) $recurBill;
    }

    /**
     * Get $this->recurBill
     *
     * @return string
     */
    public function getRecurBill()
    {
        return $this->recurBill;
    }

    /**
     * Set $this->autoBill
     * @todo the "settype" of autoBill
     * @param settype $autoBill
     */
    public function setAutoBill($autoBill)
    {
        $this->autoBill = (string) $autoBill;
    }

    /**
     * Get $this->autoBill
     * @todo the "gettype" of autoBill
     * @return gettype
     */
    public function getAutoBill()
    {
        return $this->autoBill;
    }

    /**
     * Set $this->nextBill
     *
     * @param settype $nextBill
     */
    public function setNextBill($nextBill)
    {
        $this->nextBill = (string) $nextBill;
    }

    /**
     * Get $this->nextBill
     *
     * @return gettype
     */
    public function getNextBill()
    {
        return $this->nextBill;
    }

    /**
     * Set $this->regStatus
     * @param string $regStatus
     */
    public function setRegStatus($regStatus)
    {
        $this->regStatus = (string) $regStatus;
    }

    /**
     * Get $this->regStatus;
     *
     * @return type
     */
    public function getRegStatus()
    {
        return $this->regStatus;
    }

    /**
     * Set $this->notes
     *
     * @param settype $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }

    /**
     * Get $this->notes
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Get $this->password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set $this->password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = (string) $password;
    }
}
