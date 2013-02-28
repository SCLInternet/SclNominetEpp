<?php
namespace SclNominetEpp;

/**
 * A contact record
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class Contact extends \SclContact\Contact
{
        //TYPE
    const TYPE_UK_LTD                   = 'LTD';
    const TYPE_UK_PLC                   = 'PLC';
    const TYPE_UK_PARTNERSHIP           = 'PTNR';
    const TYPE_UK_SOLETRADER            = 'STRA';
    const TYPE_UK_LTD_LIABILITY_PTNR    = 'LLP';
    const TYPE_UK_INDUSTRIAL_PROVIDENT  = 'IP';
    const TYPE_UK_INDIVIDUAL            = 'IND';
    const TYPE_UK_SCH                   = 'SCH';
    const TYPE_UK_REG_CHARITY           = 'RCHAR';
    const TYPE_UK_GOV                   = 'GOV';
    const TYPE_UK_CORP_BY_ROYAL_CHARTER = 'CRC';
    const TYPE_UK_STAT_BODY             = 'STAT';
    const TYPE_UK_OTHER                 = 'OTHER';
    //A UK Entity that does not fit in to any of the above, (e.g. clubs, associations, many universities)

    const TYPE_NON_UK_IND   = 'FIND';
    const TYPE_NON_UK_CORP  = 'FCORP';
    const TYPE_NON_UK_OTHER = 'FOTHER';
    //A Non-UK Entity that does not fit....

    const TYPE_UNKNOWN = 'UNKNOWN';

    /**
     * array of organisation types.
     *
     * @var array
     */
    private static $companyTypes = array(
        self::TYPE_UK_LTD,
        self::TYPE_UK_PLC,
        self::TYPE_UK_PARTNERSHIP,
        self::TYPE_UK_SOLETRADER,
        self::TYPE_UK_LTD_LIABILITY_PTNR,
        self::TYPE_UK_INDUSTRIAL_PROVIDENT,
        self::TYPE_UK_INDIVIDUAL,
        self::TYPE_UK_SCH,
        self::TYPE_UK_REG_CHARITY,
        self::TYPE_UK_GOV,
        self::TYPE_UK_CORP_BY_ROYAL_CHARTER,
        self::TYPE_UK_STAT_BODY,
        self::TYPE_UK_OTHER,
        self::TYPE_NON_UK_IND,
        self::TYPE_NON_UK_CORP,
        self::TYPE_NON_UK_OTHER,
        self::TYPE_UNKNOWN
    );

    /**
     * The Contact identifier.
     *
     * @var string
     */
    private $id;

    /**
     * The registered company number or the DfES UK school number of the registrant.
     *
     * @var string
     */
    private $companyNumber;

    /**
     * The name of the organisation associated with the contact.
     * @todo rename all instances of organisation to company.
     * @var string
     */

    /**
     * The optOut is used to prevent the registrant's address details
     * from being published in nominet's WHOIS system. (default value 'y', alternative 'n')
     * Converted to true (y),  false (n).
     *
     * @var boolean
     */
    private $optOut = true;

    /**
     * The date and time of contact-object creation.
     *
     * @var DateTime
     */
    private $created;
    /**
     * The date and time of the most recent contact-object modification.
     *
     * @var DateTime
     */
    private $upDate;

    /**
     * Trading name of the organisation
     *
     * @var string
     */
    private $tradeName;

    /**
     * The type of organisation (from the array defined in the Contact class) default "UNKNOWN".
     *
     * @var string
     */
    private $companyType = self::TYPE_UNKNOWN;

    /**
     *
     *
     * @var string
     */
    private $type;

    /**
     *
     */
    private $clientID;

    /**
     * Constructor
     */
    public function __construct()
    {

    }

    /**
     * Set $id
     *
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = (string) $id;
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

    /**
     * Set $companyNumber
     *
     * @param string $companyNumber
     */
    public function setCompanyNumber($companyNumber)
    {
        $this->companyNumber = (string) $companyNumber;
    }

    /**
     * Get $companyNumber
     *
     * @return string
     */
    public function getCompanyNumber()
    {
        return $this->companyNumber;
    }

    /**
     * Set $optOut
     *
     * @param boolean $optOut
     */
    public function setOptOut($optOut)
    {
        $this->optOut = $optOut;
    }

    /**
     * Get $optOut
     *
     * @return string
     */
    public function getOptOut()
    {
        return $this->optOut;
    }

    /**
     * Set $this->created
     *
     * @param DateTime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * Get $this->created
     *
     * @return DateType
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set $this->upDate
     *
     * @param DateTime $upDate
     */
    public function setUpDate($upDate)
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
     * Set $this->tradeName
     *
     * @param string $tradeName
     */
    public function setTradeName($tradeName)
    {
        $this->tradeName = (string) $tradeName;
    }

    /**
     * Get $this->tradeName
     *
     * @return string
     */
    public function getTradeName()
    {
        return $this->tradeName;
    }

    /**
     * Set $this->organisationType
     *
     * @param string $organisationType
     */
    public function setCompanyType($companyType)
    {
        if (!in_array((string) $companyType, self::$companyTypes)) {
            throw new \Exception("Invald organisation type: $companyType");
        }
        $this->companyType = (string) $companyType;
    }

    /**
     * Get $this->organisationType
     *
     * @return string
     */
    public function getCompanyType()
    {
        return $this->companyType;
    }

    /**
     * Set $this->type
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get $this->type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
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
     * @return gettype
     */
    public function getClientID()
    {
        return $this->clientID;
    }
}
