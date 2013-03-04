<?php
namespace SclNominetEpp;

/**
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */

/**
 * A handshake record
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Handshake
{
    /**
     * The identifier of the handshake.
     *
     * @var mixed
     */
    private $caseId;

    /**
     * The registrant of the handshake.
     *
     * @var string
     */
    private $registrant;

    /**
     * The number of domains within the handshake.
     *
     * @var int
     */
    private $numberOfDomains;

    /**
     * An array of domains involved in the handshake.
     *
     * @var array
     */
    private $domainList = array();

    /**
     * Set case Id.
     *
     * @param mixed $caseId
     */
    public function setCaseId($caseId)
    {
        $this->caseId = (int)(string) $caseId;
    }

    /**
     * Get case Id.
     *
     * @return mixed
     */
    public function getCaseId()
    {
        return $this->caseId;
    }

    /**
     * Get the number of domains within the handshake.
     *
     * @return int
     */
    public function getNumberOfDomains()
    {
        return $this->numberOfDomains;
    }

    /**
     * Set the number of domains within the handshake.
     *
     * @param int $numberOfDomains
     */
    public function setNumberOfDomains($numberOfDomains)
    {
        $this->numberOfDomains = $numberOfDomains;
    }

    /**
     * Add to the domain list
     *
     * @param string $domain
     */
    public function addDomain($domain)
    {
        $this->domainList[] = (string) $domain;
    }

    /**
     * Set domain list.
     *
     * @param array $domainList
     */
    public function setDomainList($domainList)
    {
        $this->domainList = $domainList;
    }

    /**
     * Get domain list
     *
     * @return array
     */
    public function getDomainList()
    {
        return $this->domainList;
    }

    /**
     * Set the handshake registrant
     *
     * @param string $registrant
     */
    public function setRegistrant($registrant)
    {
        $this->registrant = (string) $registrant;
    }

    /**
     * Get the handshake registrant
     *
     * @return string
     */
    public function getRegistrant()
    {
        return $this->registrant;
    }
}
