<?php

namespace SclNominetEpp\Response\Update\Unrenew;

use SclNominetEpp\Response;
use SimpleXMLElement;
use DateTime;

/**
 * This class interprets XML for a Nominet EPP unrenew command response.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Unrenew extends Response
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
        if (!$this->success()) {
            return;
        }
        if (!$this->xmlValid($xml->response->resData)) {
            return;
        }
        $name = $this->valueName;
        $ns = $xml->getNamespaces(true);
        $response = $xml->response;

        $renData = $response->resData->children($ns['domain'])->renData;

        foreach ($renData as $renDataTag) {

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

    public function getObject()
    {
        return $this->object;
    }
}
