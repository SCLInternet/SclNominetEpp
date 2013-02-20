<?php

namespace SclNominetEpp\Response\Info;

use SclNominetEpp\Response;
use SimpleXMLElement;

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
    public function __construct($type, AbstractInfo $object, $valueName)
    {
        $this->type = (string) $type;
        $this->object = $object;
        $this->valueName = (string) $valueName;
    }
    
    /**
     * 
     * @todo The return type?
     * @param SimpleXMLElement $xml
     * @return mixed
     */
    public function processData(SimpleXMLElement $xml)
    {
        if (!$this->xmlValid($xml->response->resData)) {
            return;
        }
        $name = $this->valueName;
        $ns = $xml->getNamespaces(true);
        $response = $xml->response;

        $infData = $response->resData->children($ns[$this->type])->infData;
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
    protected function xmlValid(SimpleXMLElement $xml)
    {
        return isset($xml);
    }
    
    /**
     * Allows the child classes to include specific data that could not be abstracted.
     * 
     * @param SimpleXMLElement $infData
     * @param SimpleXMLElement $extension
     */
    protected function addSpecificData(SimpleXMLElement $infData, SimpleXMLElement $extension = null)
    {
        $this->addInfData($infData);
        $this->addExtensionData($extension);
    }
    
    /**
     * @param SimpleXMLElement $infData This is the normal data
     */
    abstract protected function addInfData(SimpleXMLElement $infData);
    
    /**
     * @param SimpleXMLElement $extension This is the extension data
     */
    abstract protected function addExtensionData(SimpleXMLElement $extension);
    
    /**
     * @param SimpleXMLElement $infData
     */
    abstract protected function setValue(SimpleXMLElement $infData);
    
    /**
     * Getter for the currently initialised child object.
     * 
     * @return object
     */
    public function getObject()
    {
        return $this->object;
    }
}
