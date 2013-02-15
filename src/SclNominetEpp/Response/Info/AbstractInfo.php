<?php

namespace SclNominetEpp\Response\Info;

use SclNominetEpp\Response;

/**
 * This class interprets XML for a Nominet EPP info command response.
 * @todo this class is based on the Response Info Domain Class, 
 * anything "domain" specific should be generalised, report to the author below.
 * 
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
abstract class AbstractInfo extends Response
{
    protected $object;

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
    
    public function processData($xml)
    {
        if ($this->xmlInvalid($xml)) {
            return;
        }
        $name = $this->valueName;
        $ns = $xml->getNamespaces(true);
        $response = $xml->response;

        $infData = $response->resData->children($ns["{$this->type}"])->infData;
        $extension = $response->extension->children($ns["{$this->type}-nom-ext"])->infData;
        $this->object->setValue($infData->$name);
        $this->object->setClientID($infData->clID);
        $this->object->setCreated(new DateTime((string) $infData->crDate));
        $this->object->setUpDate(new DateTime((string) $infData->upDate));
        
        if (!isset($extension)) {
            $this->addSpecificData($infData);
        } else {
            $this->addSpecificData($infData, $extension);
        }
    }

    /**
     * Assuming $xml is invalid, 
     * this function returns "true" to affirm that the xml is invalid, 
     * otherwise "false".
     * 
     * @param SimpleXMLElement $xml
     * @return boolean
     */
    protected function xmlInvalid(SimpleXMLElement $xml)
    {
        return !isset($xml->response->resData);
    }
    
    abstract protected function addSpecificData(SimpleXMLElement $infData, SimpleXMLElement $extension = null);
    
    abstract protected function addInfData(SimpleXMLElement $infData);
    
    abstract protected function addExtension(SimpleXMLElement $extension);
    
    abstract protected function setValue(SimpleXMLElement $infData);
    
    public function getObject()
    {
        return $this->object;
    }
}
