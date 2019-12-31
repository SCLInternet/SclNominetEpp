<?php

namespace SclNominetEpp\Request\Update\Lock;

use SclNominetEpp\Request;

/**
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Lock extends Request
{
    const OBJECT_CONTACT = 'contact';
    const OBJECT_DOMAIN  = 'domain';
    const TYPE_INVESTIGATION = 'investigation';
    const TYPE_OPTOUT        = 'opt-out';

    /**
     * all accepted objects of Lock command.
     *
     * @var array
     */
    private static $objects = array(
        self::OBJECT_CONTACT,
        self::OBJECT_DOMAIN
    );

    /**
     * All acceptable types of Lock command.
     *
     * @var array
     */
    private static $types = array(
        self::TYPE_INVESTIGATION,
        self::TYPE_OPTOUT
    );

    /**
     * Contact Id.
     *
     * @var string
     */
    protected $contactId;

    /**
     * Domain Name.
     *
     * @var string
     */
    protected $domainName;


    protected $objectIdentifier;
    /**
     * Either a "contact" or a "domain"
     *
     * @var string
     */
    protected $object;

    /**
     * Either "investigation" or "opt-out"
     *
     * @var string
     */
    protected $type;

    /**
     * Initialises the object string, and type string.
     * Feeds the expected response to the request class.
     *
     * @param string $object
     * @param string $type
     * @param object $response
     */
    public function __construct($object, $type, $response = null)
    {
        parent::__construct('update', $response);
        if (in_array($object, self::$objects)) {
            $this->object = $object;
        }
        if (in_array($type, self::$types)) {
            $this->type   = $type;
        }
    }

    /**
     * Set the contact id
     *
     * @param string $contactId
     * @return AbstractLock
     */
    public function setContactId($contactId)
    {
        $this->contactId = (string)$contactId;

        return $this;
    }

    /**
     * Set the domain name
     *
     * @param string $domainName
     * @return AbstractLock
     */
    public function setDomainName($domainName)
    {
        $this->domainName = $domainName;

        return $this;
    }

    /**
     * {@inheritDoc}
     *
     */
    protected function addContent(\SimpleXMLElement $xml)
    {
        $lockNS  = 'http://www.nominet.org.uk/epp/xml/std-locks-1.0';
        $lockXSI = $lockNS . ' std-locks-1.0.xsd';

        //$domainNS  = 'urn:ietf:params:xml:ns:domain-1.0';
        //$domainXSI = 'urn:ietf:params:xml:ns:domain-1.0 domain-1.0.xsd';

        $lock = $xml->addChild('l:lock', '', $lockNS);
        $lock->addAttribute('xsi:schemaLocation', $lockXSI, $lockNS);
        $lock->addAttribute('object', $this->object);   //Can be contact or domain
        $lock->addAttribute('type', $this->type); //Can be opt-out or investigate

        if (self::TYPE_INVESTIGATION === $this->type) {
            $this->investigate($lock);
        }
        if (self::TYPE_OPTOUT === $this->type) {
            $this->optOut($lock);
        }
        if (self::OBJECT_CONTACT !== $this->object) {
            throw new Exception("Invalid string for \$object ");
        }
    }

    private function investigate($lock)
    {
        $this->checkInvalidSetup();

        if (self::OBJECT_DOMAIN === $this->object) {
            $lock->addChild('domainName', $this->domainName);
            return;
        }
        $this->idChildDecider($lock);
    }

    private function optOut($lock)
    {
        $this->checkInvalidSetup();

        $this->idChildDecider($lock);
    }

    private function checkInvalidSetup()
    {
        if (null !== $this->contactId && null !== $this->domainName) {
            throw new Exception("Both ContactId and DomainName set, only one should be set.");
        }
    }

    private function idChildDecider($lock)
    {
        if (null !== $this->contactId) {
            $lock->addChild('contactId', $this->contactId);
        }
        if (null !== $this->domainName) {
            $lock->addChild('domainName', $this->domainName);
        }
    }
}
