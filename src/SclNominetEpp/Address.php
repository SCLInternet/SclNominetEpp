<?php

namespace SclNominetEpp;

/**
 * DocBlock: Description of Address
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Address
{

    /**
     *
     * @var string
     */
    private $addressLineOne;
    /**
     *
     * @var string
     */
    private $addressLineTwo = null;
    /**
     *
     * @var string
     */
    private $addressLineThree = null;
    /**
     *
     * @var string
     */
    private $city;
    /**
     * State or Province
     *
     * @var string
     */
    private $stateProvince = null;
    /**
     * Post Code
     *
     * @var string
     */
    private $postCode = null;
    /**
     * Country Code
     *
     * @var string
     */
    private $countryCode;

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
        $this->addressLineOne = (string)$addressLineOne;
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
        $this->addressLineTwo = (string)$addressLineTwo;
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
        $this->addressLineThree = (string)$addressLineThree;
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
        $this->city = (string)$city;
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
        $this->postCode = (string)$postCode;
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
        $this->countryCode = (string)$countryCode;
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
