<?php

namespace SclNominetEpp\Response\Info;

use SclNominetEpp\Response;
use SimpleXMLElement;
use DateTime;

/**
 * This class interprets XML for a Nominet EPP info command response.
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
        $this->valueName = (string) $valueName;
    }
    
    /**
     * {@inheritDoc}
     * 
     * @param SimpleXMLElement $xml
     * @return void
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
        $this->setValue($infData->$name);
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
