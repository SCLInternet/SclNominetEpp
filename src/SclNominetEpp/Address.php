<?php

namespace SclNominetEpp;

/**
 * DocBlock: Description of Address
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Address extends \SclContact\Address
{
    /**
     * An array of all the country codes (as of 18/02/2013 (DD/MM/YYYY))
     *
     * @var array
     */
    private static $countryCodes = array(
        'AD', 'AE', 'AF', 'AG', 'AI', 'AL', 'AM', 'AO', 'AQ', 'AR', 'AS', 'AT',
        'AU', 'AW', 'AX', 'AZ',
        'BA', 'BB', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BL', 'BM', 'BN',
        'BO', 'BQ', 'BR', 'BS', 'BT', 'BV', 'BW', 'BY', 'BZ',
        'CA', 'CC', 'CD', 'CF', 'CG', 'CH', 'CI', 'CK', 'CL', 'CM', 'CN', 'CO',
        'CR', 'CU', 'CV', 'CW', 'CX', 'CY', 'CZ',
        'DE', 'DJ', 'DK', 'DM', 'DO', 'DZ',
        'EC', 'EE', 'EG', 'EH', 'ER', 'ES', 'ET',
        'FI', 'FJ', 'FK', 'FM', 'FO', 'FR',
        'GA', 'GB', 'GD', 'GE', 'GF', 'GG', 'GH', 'GI', 'GL', 'GM', 'GN', 'GP',
        'GQ', 'GR', 'GS', 'GT', 'GU', 'GW', 'GY',
        'HK', 'HM', 'HN', 'HR', 'HT', 'HU',
        'ID', 'IE', 'IL', 'IM', 'IN', 'IO', 'IQ', 'IR', 'IS', 'IT',
        'JE', 'JM', 'JO', 'JP',
        'KE', 'KG', 'KH', 'KI', 'KM', 'KN', 'KP', 'KR', 'KW', 'KY', 'KZ',
        'LA', 'LB', 'LC', 'LI', 'LK', 'LR', 'LS', 'LT', 'LU', 'LV', 'LY',
        'MA', 'MC', 'MD', 'ME', 'MF', 'MG', 'MH', 'MK', 'ML', 'MM', 'MN', 'MO',
        'MP', 'MQ', 'MR', 'MS', 'MT', 'MU', 'MV', 'MW', 'MX', 'MY', 'MZ',
        'NA', 'NC', 'NE', 'NF', 'NG', 'NI', 'NL', 'NO', 'NP', 'NR', 'NU', 'NZ',
        'OM',
        'PA', 'PE', 'PF', 'PG', 'PH', 'PK', 'PL', 'PM', 'PN', 'PR', 'PS', 'PT',
        'PW', 'PY',
        'QA',
        'RE', 'RO', 'RS', 'RU', 'RW',
        'SA', 'SB', 'SC', 'SD', 'SE', 'SG', 'SH', 'SI', 'SJ', 'SK', 'SL', 'SM',
        'SN', 'SO', 'SR', 'SS', 'ST', 'SX', 'SY', 'SZ',
        'TC', 'TD', 'TF', 'TG', 'TH', 'TJ', 'TK', 'TL', 'TM', 'TN', 'TO', 'TR',
        'TT', 'TV', 'TW', 'TZ',
        'UA', 'UG', 'UM', 'US', 'UY', 'UZ',
        'VA', 'VC', 'VE', 'VG', 'VI', 'VN', 'VU',
        'WF', 'WS',
        'YE', 'YT',
        'ZA', 'ZM', 'ZW'
    );

    /**
     * First line of an address
     * specified as <street> in the nominet EPP.
     *
     * @var string
     */
    private $addressLineOne;
    /**
     * Second line of an address
     * specified as <street> in the nominet EPP.
     *
     * @var string
     */
    private $addressLineTwo = null;
    /**
     * Third line of an address
     * specified as <street> in the nominet EPP.
     *
     * @var string
     */
    private $addressLineThree = null;
    /**
     * The City of an address
     *
     * @var string
     */
    private $city;
    /**
     * The State or Province of an address
     *
     * @var string
     */
    private $stateProvince = null;
    /**
     * The Post Code of an address
     *
     * @var string
     */
    private $postCode = null;
    /**
     * The Country Code of an address
     *
     * @var string
     */
    private $countryCode;

    /**
     * Constructor
     */
    public function __construct()
    {

    }

    /**
     * Set $this->addressLineOne
     *
     * @param string $addressLineOne
     */
    public function setAddressLineOne($addressLineOne)
    {
        $this->addressLineOne = (string) $addressLineOne;
    }

    /**
     * Get $this->addressLineOne
     *
     * @return string
     */
    public function getAddressLineOne()
    {
        return $this->addressLineOne;
    }

    /**
     * Set $this->addressLineTwo
     *
     * @param string $addressLineTwo
     */
    public function setAddressLineTwo($addressLineTwo)
    {
        $this->addressLineTwo = (string) $addressLineTwo;
    }

    /**
     * Get $this->addressLineTwo
     *
     * @return string
     */
    public function getAddressLineTwo()
    {
        return $this->addressLineTwo;
    }

    /**
     * Set $this->addressLineThree
     *
     * @param string $addressLineThree
     */
    public function setAddressLineThree($addressLineThree)
    {
        $this->addressLineThree = (string) $addressLineThree;
    }

    /**
     * Get $this->addressLineThree
     *
     * @return string
     */
    public function getAddressLineThree()
    {
        return $this->addressLineThree;
    }

    /**
     * Set $this->city
     *
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = (string) $city;
    }

    /**
     * Get $this->city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set $this->stateProvince
     *
     * @param string $stateProvince
     */
    public function setStateProvince($stateProvince)
    {
        $this->stateProvince = (String)$stateProvince;
    }

    /**
     * Get $this->stateProvince
     *
     * @return string
     */
    public function getStateProvince()
    {
        return $this->stateProvince;
    }

    /**
     * Set $this->postCode
     *
     * @param string $postCode
     */
    public function setPostCode($postCode)
    {
        $this->postCode = (string) $postCode;
    }

    /**
     * Get $this->postCode
     *
     * @return string
     */
    public function getPostCode()
    {
        return $this->postCode;
    }

    /**
     * Set $this->countryCode
     *
     * @param string $countryCode
     */
    public function setCountryCode($countryCode)
    {
        if (!in_array((string) $countryCode, self::$countryCodes)) {
            throw new \Exception("Invald country code: $countryCode");
        }
        $this->countryCode = (string) $countryCode;
    }

    /**
     * Get $this->countryCode
     *
     * @return gettype
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }
}
