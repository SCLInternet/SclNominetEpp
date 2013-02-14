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

    public function __construct($type, $objectType, $valueName)
    {
        $this->type = (string) $type;
        $this->objectType = $objectType;
        $this->valueName = $valueName;
    }
    
    protected function processData($xml)
    {
        $name = $this->valueName;
        
        if($this->xmlInvalid($xml)){
            return;
        }
        $ns = $xml->getNamespaces(true);
        $objectType = $this->objectType;
        $this->object = new $objectType();

        $response = $xml->response;

        $creData  = $response->resData->children($ns[$this->type])->creData;
        $this->object->setValue($creData->$name);
        $this->object->setCreated(new DateTime($creData->crDate));
        //$this->addSpecificData($creData);
    }

    protected function xmlInvalid($xml)
    {   
        return !isset($xml->response->resData);
    }
    
    /**
     * Set $this->type
     *
     * @param string $type
     */
    abstract protected function setValue(\SimpleXMLElement $xml);
    
//    protected function addSpecificData(\SimpleXMLElement $xml)
//    {
//    }
    
    public function getObject()
    {
        return $this->object;
    }
    
    /**
     * Set $this->type
     *
     * @param string $type
     */
    protected function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get $this->type
     *
     * @return string
     */
    protected function getType()
    {
        return $this->type;
    }

    /**
     * Set $this->valueName
     *
     * @param string $valueName
     */
    public function setValueName($valueName)
    {
        $this->valueName = $valueName;
    }

    /**
     * Get $this->valueName
     *
     * @return string
     */
    public function getValueName()
    {
        return $this->valueName;
    }
}
