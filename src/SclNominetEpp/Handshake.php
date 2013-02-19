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
    public $caseId;
    
    /**
     * The number of domains within the handshake.
     * @var int
     */
    public $numberOfDomains;
    
    /**
     * An array of domains involved in the handshake.
     * 
     * @var array 
     */

    public $domainList = array();
    
    /**
     * Set case Id.
     * 
     * @param mixed $caseId
     */
    public function setCaseId($caseId) 
    {
        $this->caseId = $caseId;
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
        $this->domainList[] = $domain;
    }

    /**
     * Set domain list.
     * 
     * @param array $domainList
     */
    public function setDomainList($domainList) {
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

//    <h:caseId>6</h:caseId>
//        <h:domainListData noDomains="2">
//          <h:domainName>example1.co.uk</h:domainName>
//          <h:domainName>example2.co.uk</h:domainName>
//        </h:domainListData>
}
