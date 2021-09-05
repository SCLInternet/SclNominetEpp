<?php
/**
 * Contains the Nominet Renew request class definition.
 */

namespace SclNominetEpp\Request;

use SclNominetEpp\Request;
use SclNominetEpp\Response\Renew as RenewResponse;
use SimpleXMLElement;

/**
 * This class build the XML for a Nominet EPP renew command.
 */
class Renew extends Request
{
    /** @const int Default renewal period, two years (depending on unit). */
    const DEFAULT_PERIOD = 2;

    /** @const int Default renewal unit, years. */
    const DEFAULT_UNIT = 'y';

    /** @var string Format of the atomic type 'xs:date', eg: 2009-04-07 */
    const CURRENT_EXPIRY_DATE_FORMAT = 'Y-m-d';

    /**
     * The domain name.
     *
     * @var string
     */
    protected $domain;

    /**
     * The expiry date.
     *
     * @var \DateTimeInterface
     */
    protected $currentExpiryDate;

    /** @var int The period to register for. */
    protected $period = self::DEFAULT_PERIOD;

    /** @var string The unit used for the period. */
    protected $unit = self::DEFAULT_UNIT;

    /**
     * Tells the parent class what the action of this request is.
     * @param string|null $domain
     */
    public function __construct(string $domain = null)
    {
        parent::__construct('renew', new RenewResponse());
        if ($domain) {
            $this->domain = $domain;
        }
    }

    /**
     * Set the domain
     *
     * @param string $domain
     * @param \DateTimeInterface|null $currentExpiryDate
     * @return \SclNominetEpp\Request\Renew
     */
    public function setDomain(string $domain, \DateTimeInterface $currentExpiryDate = null)
    {
        $this->domain = $domain;

        if ($currentExpiryDate) {
            $this->setDate($currentExpiryDate);
        }

        return $this;
    }

    /**
     * Set the date
     *
     * @param \DateTimeInterface $currentExpiryDate
     * @return \SclNominetEpp\Request\Renew
     */
    public function setDate(\DateTimeInterface $currentExpiryDate)
    {
        $this->currentExpiryDate = $currentExpiryDate;
        return $this;
    }

    /**
     * Set the period
     *
     * @param int $period
     * @return \SclNominetEpp\Request\Renew
     */
    public function setPeriod(int $period)
    {
        $this->period = $period;
        return $this;
    }

    /**
     * Set the unit
     *
     * @param string $unit
     * @return \SclNominetEpp\Request\Renew
     */
    public function setUnit(string $unit)
    {
        $this->unit = $unit;
        return $this;
    }

    /**
     * @param string $format
     * @return string
     */
    public function getCurrentExpiryDate($format = self::CURRENT_EXPIRY_DATE_FORMAT): string
    {
        if ($this->currentExpiryDate === null) {
            throw new \InvalidArgumentException('Current Expiry Date is required.');
        }
        return $this->currentExpiryDate->format($format);
    }

    /**
     * (non-PHPdoc)
     * @param SimpleXMLElement $xml
     * @see Request.AbstractRequest::addContent()
     *
     */
    protected function addContent(SimpleXMLElement $xml)
    {
        $domainNS = 'urn:ietf:params:xml:ns:domain-1.0';
        $domainXSI = $domainNS . ' domain-1.0.xsd';

        $domainRenew = $xml->addChild('domain:renew', '', $domainNS);
        $domainRenew->addAttribute('xsi:schemaLocation', $domainXSI, self::XSI_NAMESPACE);
        $domainRenew->addChild('name', $this->domain);
        $domainRenew->addChild('curExpDate', $this->getCurrentExpiryDate());
        $period = $domainRenew->addChild('period', $this->period);
        $period->addAttribute('unit', $this->unit);
    }
}
