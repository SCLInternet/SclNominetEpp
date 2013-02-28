<?php
namespace SclNominetEpp;

/**
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */

/**
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Greeting
{

    const ACCESS_ALL  = "all";
    const ACCESS_NONE = "none";
    const ACCESS_NULL = "null";
    const ACCESS_PERSONAL           = "personal";
    const ACCESS_PERSONAL_AND_OTHER = "personalAndOther";
    const ACCESS_OTHER              = "other";

    /**
     *
     * {@link http://tools.ietf.org/html/rfc5730#section-2.4 <access> children documentation}
     *
     * @var array
     */
    protected static $accessTags = array(
        self::ACCESS_ALL,
        self::ACCESS_NONE,
        self::ACCESS_NULL,
        self::ACCESS_PERSONAL,
        self::ACCESS_PERSONAL_AND_OTHER,
        self::ACCESS_OTHER
    );


    const PURPOSE_ADMIN   = "admin";
    const PURPOSE_CONTACT = "contact";
    const PURPOSE_PROV    = "prov";
    const PURPOSE_OTHER   = "other";

    /**
     * {@link http://tools.ietf.org/html/rfc5730#section-2.4 <purpose> children documentation}
     *
     * @var array
     */
    protected static $purposeTags = array(
        self::PURPOSE_ADMIN,
        self::PURPOSE_CONTACT,
        self::PURPOSE_PROV,
        self::PURPOSE_OTHER
    );

    const RECIPIENT_OTHER     = "other";
    const RECIPIENT_OURS      = "ours";
    const RECIPIENT_PUBLIC    = "public";
    const RECIPIENT_SAME      = "same";
    const RECIPIENT_UNRELATED = "unreleated";

    /**
     * {@link http://tools.ietf.org/html/rfc5730#section-2.4 <purpose> children documentation}
     *
     * @var array
     */
    protected static $recipientTags = array(
        self::RECIPIENT_OTHER,
        self::RECIPIENT_OURS,
        self::RECIPIENT_PUBLIC,
        self::RECIPIENT_SAME,
        self::RECIPIENT_UNRELATED
    );

    const RETENTION_BUSINESS   = "business";
    const RETENTION_INDEFINITE = "indefinite";
    const RETENTION_LEGAL      = "legal";
    const RETENTION_NONE       = "none";

     /**
     * {@link http://tools.ietf.org/html/rfc5730#section-2.4 <purpose> children documentation}
     *
     * @var array
     */
    protected static $retentionTags = array(
        self::RETENTION_BUSINESS,
        self::RETENTION_INDEFINITE,
        self::RETENTION_LEGAL,
        self::RETENTION_NONE
    );

    const EXPIRY_ABSOLUTE = "absolute";
    const EXPIRY_RELATIVE = "relative";

    /**
     * {@link http://tools.ietf.org/html/rfc5730#section-2.4 <purpose> children documentation}
     *
     * @var array
     */
    protected static $expiryTags = array(
        self::EXPIRY_ABSOLUTE,
        self::EXPIRY_RELATIVE
    );

    /**
     * The server name.
     *
     * @var string
     */
    protected $serverId;

    /**
     * The server's current date and time in UTC.
     *
     * @var type
     */
    protected $serverDate;

    /**
     * The protocol version supported by the server.
     *
     * @var float
     */
    protected $version;

    /**
     * Language known by the server.
     *
     * @var string
     */
    protected $language;

    /**
     * Namespace URIs for the objects that can be manipulated in the session.
     *
     * @var array
     */
    protected $objectURIs = array();

    /**
     * Namespace extension URIs for objects that can be manipulated during the session.
     *
     * @var array
     */
    protected $extensionURIs = array();

    /**
     * The access level of the Data Collection Policy.
     *
     * @var string
     */
    protected $access;

    /**
     *
     * @var type
     */
    protected $purposes = array();

    /**
     *
     * @var type
     */
    protected $recipients = array();

    /**
     *
     * @var type
     */
    protected $retention;

    /**
     * getServerId
     *
     * @return string
     */
    public function getServerId()
    {
        return $this->serverId;
    }

    /**
     *
     * @param string $serverId
     */
    public function setServerId($serverId)
    {
        $this->serverId = $serverId;
    }

    /**
     *
     * @return DateTime
     */
    public function getServerDate()
    {
        return $this->serverDate;
    }

    /**
     *
     * @param DateTime $serverDate
     */
    public function setServerDate($serverDate)
    {
        $this->serverDate = $serverDate;
    }

    /**
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     *
     * @param string $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     *
     * @param string $languages
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    public function getObjectURIs()
    {
        return $this->objectURIs;
    }

    public function addObjectURI($objectURI)
    {
        $this->objectURIs[] = (string) $objectURI;
    }

    public function getExtensionURIs()
    {
        return $this->extensionURIs;
    }

    public function addExtensionURI($extensionURI)
    {
        $this->extensionURIs[] = (string) $extensionURI;
    }

    public function getAccess()
    {
        return $this->access;
    }

    public function setAccess($access)
    {
        echo (string) $access;
        if (!in_array((string) $access, self::$accessTags)) {
            throw new \Exception("Invald access Tag: $access");
        }
        $this->access = (string)$access;
    }

    public function getPurposes()
    {
        return $this->purposes;
    }

    public function addPurpose($purpose)
    {
        $this->purposes[] = (string)$purpose;
    }

    public function getRecipients()
    {
        return $this->recipients;
    }

    public function addRecipient($recipient)
    {
        $this->recipients[] = $recipient;
    }

    public function getRetention()
    {
        return $this->retention;
    }

    public function setRetention($retention)
    {
        $this->retention = $retention;
    }
}
