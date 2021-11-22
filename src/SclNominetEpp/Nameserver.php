<?php
namespace SclNominetEpp;

use DateTime;

/**
 * A nameserver record.
 *
 * @author Tom Oram <tom@scl.co.uk
 * @todo Add format checking for IPv4 and IPv6
 */
class Nameserver
{
    /**
     * The nameserver host name
     *
     * @var string
     */
    private $hostName;

    /**
     * Array of status of a Nameserver
     *
     * @var array|string
     */
    private $status = array();

    /**
     * The identifier of the sponsoring client.
     *
     * @var string
     */
    private $clientID;

    /**
     * The identifier of the client that created the host object
     *
     * @var string
     */
    private $creatorID;

    /**
     * The date and time of host-object creation.
     *
     * @var string
     */
    private $created;

    /**
     * The identifier of the client
     * that last updated the host object.
     *
     * @var string
     */
    private $upID = "";

    /**
     * The date and time of the most recent
     * host-object modification
     *
     * @var string
     */
    private $upDate;

    /**
     * The v4 IP address
     *
     * @var string
     */
    private $ipv4 = null;

    /**
     * The v6 IP address
     *
     * @var string
     */
    private $ipv6 = null;

    /**
     * @var string
     */
    private $id;

    /**
     * Set $this->hostName
     *
     * @param string $hostName
     */
    public function setHostName($hostName)
    {
        $this->hostName = (string) $hostName;
    }

    /**
     * Get $this->hostName
     *
     * @return string
     */
    public function getHostName()
    {
        return $this->hostName;
    }

    /**
     * Set $this->status
     *
     * @param string $status
     */
    public function addStatus($status)
    {
        $this->status[] = (string) $status;
    }

    /**
     * Get $this->status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
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
     * Set $this->clientID
     *
     * @param string $clientID
     */
    public function setClientID($clientID)
    {
        $this->clientID = (string) $clientID;
    }

    /**
     * Get $this->clientID
     *
     * @return string
     */
    public function getClientID()
    {
        return $this->clientID;
    }

    /**
     * Set the ID of the user that last changed the domain name.
     *
     * @param string $upID
     */
    public function setUpID($upID)
    {
        $this->upID = (string) $upID;
    }

    /**
     * Get the ID of the user that last changed the domain name.
     *
     * @return string
     */
    public function getUpID()
    {
        return $this->upID;
    }

    /**
     * Set the date the domain name was last changed.
     *
     * @param DateTime $upDate
     */
    public function setUpDate(DateTime $upDate)
    {
        $this->upDate = $upDate->format(DateTime::ATOM);
    }

    /**
     * Get the date the domain name was last changed.
     *
     * @return DateTime
     */
    public function getUpDate()
    {
        return DateTime::createFromFormat(DateTime::ATOM, $this->upDate);
    }

    /**
     * Set $this->ipv4
     *
     * @param string $ipv4
     */
    public function setIpv4($ipv4)
    {
        $this->ipv4 = (string) $ipv4;
    }

    /**
     * Get $this->ipv4
     *
     * @return string
     */
    public function getIpv4()
    {
        return $this->ipv4;
    }

    /**
     * Set $this->ipv6
     *
     * @param string $ipv6
     */
    public function setIpv6($ipv6)
    {
        $this->ipv6 = (string) $ipv6;
    }

    /**
     * Get $this->ipv6
     *
     * @return string
     */
    public function getIpv6()
    {
        return $this->ipv6;
    }

    /**
     * Set $id
     *
     * @param string $id
     */
    public function setId(string $id)
    {
        $this->id = $id;
    }

    /**
     * Get $id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
}
