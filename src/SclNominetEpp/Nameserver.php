<?php

namespace SclNominetEpp;

use DateTime;
use InvalidArgumentException;

class Nameserver
{
    use Traits\UpDateTrait;

    /**
     * The nameserver host name
     */
    private string $hostName;

    /**
     * Array of status of a Nameserver
     */
    private array $status = [];

    /**
     * The identifier of the sponsoring client.
     */
    private string $clientID;

    /**
     * The identifier of the client that created the host object
     */
    private string $creatorID;

    /**
     * The date and time of host-object creation.
     */
    private DateTime $created;

    /**
     * The identifier of the client
     * that last updated the host object.
     */
    private string $upID = '';

    private ?string $ipv4 = null;

    private ?string $ipv6 = null;

    private string $id;

    public function addStatus(string $status)
    {
        $this->status[] = $status;
    }

    public function __toString(): string
    {
        return $this->getHostName();
    }

    public function getHostName(): string
    {
        return $this->hostName;
    }

    public function setHostName(string $hostName)
    {
        if (empty($hostName)) {
            throw new InvalidArgumentException('HostName parameter is empty');
        }
        if (filter_var($hostName, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME) === false) {
            throw new InvalidArgumentException(sprintf('HostName parameter "%s" is invalid', $hostName));
        }

        /**
         * "A <domain:hostObj> element contains the fully qualified name of a known name server host object."
         * @see https://www.rfc-editor.org/rfc/rfc5731#section-1.1
         */
        if ($hostName !== rtrim($hostName, '.')) {
            $message = sprintf('HostName parameter "%s" is not the fully qualified name', $hostName);
            throw new InvalidArgumentException($message);
        }
        $this->hostName = $hostName;
    }

    public function __toArray(): array
    {
        return [
            'hostName' => $this->getHostName(),
            'status' => $this->getStatus(),
            'clientId' => $this->getClientID(),
            'creatorID' => $this->getCreatorID(),
            'created' => $this->getCreated(),
            'upID' => $this->getUpID(),
            'upDate' => $this->getUpDate(),
            'ipv4' => $this->getIpv4(),
            'ipv6' => $this->getIpv6(),
            'id' => $this->getId(),
        ];
    }

    public function getStatus(): array
    {
        return $this->status;
    }

    public function getClientID(): string
    {
        return $this->clientID;
    }

    public function setClientID(string $clientID)
    {
        $this->clientID = $clientID;
    }

    public function getCreatorID(): string
    {
        return $this->creatorID;
    }

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

    /**
     * Get the ID of the user that last changed the domain name.
     */
    public function getUpID(): string
    {
        return $this->upID;
    }

    /**
     * Set the ID of the user that last changed the domain name.
     */
    public function setUpID(string $upID)
    {
        $this->upID = $upID;
    }

    public function getIpv4(): ?string
    {
        return $this->ipv4;
    }

    public function setIpv4(string $ipv4)
    {
        if (filter_var($ipv4, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) === false) {
            throw new InvalidArgumentException('Ipv4 parameter is invalid');
        }
        $this->ipv4 = $ipv4;
    }

    public function getIpv6(): string
    {
        return $this->ipv6;
    }

    public function setIpv6(string $ipv6)
    {
        if (filter_var($ipv6, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) === false) {
            throw new InvalidArgumentException('Ipv4 parameter is invalid');
        }
        $this->ipv6 = $ipv6;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id)
    {
        $this->id = $id;
    }
}
