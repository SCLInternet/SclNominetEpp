<?php
/**
 * Contains the nominet AbstractCheck response class definition.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */

namespace SclNominetEpp\Response\Check;

use SclNominetEpp\Response;
use SimpleXMLElement;

/**
 * This class interprets XML for a Nominet EPP check command response.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
abstract class AbstractCheck extends Response
{
    /**
     * Type is the "check request type" (contact/domain/host)
     *
     * @var string
     */
    private $type;

    /**
     * Value Name is the name of the identifying value, "valueName" (name/id)
     * 
     * @var string
     */
    private $valueName;

    /**
     *
     * 
     * @var array
     */
    private $values = array();

    /**
     * Constructor
     * 
     * @param string $type
     * @param string $valueName
     */
    public function __construct($type, $valueName)
    {
        $this->type = $type;
        $this->valueName = $valueName;
    }

    /**
     * {@inheritDoc}
     * 
     * @param SimpleXMLElement $data
     * @return void
     */
    protected function processData(SimpleXMLElement $xml)
    {
        if (!$this->success()) {
            return;
        }
        if (!$this->xmlValid($xml->response->resData)) {
            return;
        }

        $ns = $xml->getNamespaces(true);

        $xmlValues = $xml->response->resData->children($ns[$this->type]);

        $valueName = $this->valueName;
        foreach ($xmlValues->chkData->cd as $value) {
            $available = (boolean) (string) $value->$valueName->attributes()->avail;
            $this->values[(string) $value->$valueName] = $available;
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
     * Get $this->values
     *
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }
}
