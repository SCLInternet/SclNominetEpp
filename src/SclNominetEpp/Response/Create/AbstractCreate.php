<?php

namespace SclNominetEpp\Response\Create;

use DateTime;
use SclNominetEpp\Response;

/**
 * This class interprets XML for a Nominet EPP <create> command response.
 * @todo finishing abstraction of create!
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
abstract class AbstractCreate extends Response
{
    protected $object;
    
    protected $type;
    protected $objectType;
    protected $valueName;

    /**
     * Constructor
     * 
     * @param string $type
     * @param object $object
     * @param string $valueName
     */
    public function __construct($type, $object, $valueName)
    {
        $this->type = (string) $type;
        $this->object = $object;
        $this->valueName = $valueName;
    }
    
    /**
     * Constructor
     * 
     * @param SimpleXMLElement $xml
     * @return type
     */
    protected function processData(\SimpleXMLElement $xml)
    {
        if ($this->xmlInvalid($xml)) {
            return;
        }
        
        $name = $this->valueName;
        $ns = $xml->getNamespaces(true);
        $response = $xml->response;

        $creData  = $response->resData->children($ns[$this->type])->creData;
        $this->object->setValue($creData->$name);
        $this->object->setCreated(new DateTime($creData->crDate));
    }

    /**
     * Assuming $xml is invalid, 
     * this function returns "true" to affirm that the xml is invalid, 
     * otherwise "false".
     * 
     * @param SimpleXMLElement $xml
     * @return boolean
     */
    protected function xmlInvalid(\SimpleXMLElement $xml)
    {
        return !isset($xml->response->resData);
    }
    
    /**
     * Set $this->type
     *
     * @param string $type
     */
    abstract protected function setValue(\SimpleXMLElement $xml);
    
    /**
     * @todo may be worth refactoring the create response to have this (as abstract) 
     * instead of overwriting the parent class.
     * 
     * @param \SimpleXMLElement $xml
     */
    protected function addSpecificData(\SimpleXMLElement $xml)
    {
    }
    
    public function getObject()
    {
        return $this->object;
    }
}
