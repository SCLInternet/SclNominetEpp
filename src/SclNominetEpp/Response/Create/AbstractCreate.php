<?php

namespace SclNominetEpp\Response\Create;

use DateTime;
use SclNominetEpp\Response;
use SimpleXMLElement;

/**
 * This class interprets XML for a Nominet EPP <create> command response.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
abstract class AbstractCreate extends Response
{
    protected $object;
    protected $type;
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
        $this->valueName = (string) $valueName;
    }

    /**
     * {@inheritDoc}
     *
     * @param SimpleXMLElement $xml
     * @return void
     */
    protected function processData(\SimpleXMLElement $xml)
    {
        if (!$this->success()) {
            return;
        }
        if (!$this->xmlValid($xml->response->resData)) {
            return;
        }

        $valueName = $this->valueName;
        $ns = $xml->getNamespaces(true);
        $response = $xml->response;

        $creData  = $response->resData->children($ns["{$this->type}"])->creData;
        $this->setIdentifier($creData->$valueName);
        $this->object->setCreated(new DateTime($creData->crDate));
        $this->addSpecificData($creData);
    }

    /**
     * Assuming $xml is valid,
     * this function returns "true" to affirm that the xml is valid,
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
     * Set $this->valueName
     *
     * @param string $valueName
     */
    abstract protected function setIdentifier($valueName);

    /**
     * @todo may be worth refactoring the create response to have this (as abstract)
     * instead of overwriting the parent class.
     *
     * @param SimpleXMLElement $xml
     */
    protected function addSpecificData(SimpleXMLElement $xml)
    {
    }

    /**
     * Get object of the Create command.
     *
     * @return object
     */
    public function getObject()
    {
        return $this->object;
    }
}
