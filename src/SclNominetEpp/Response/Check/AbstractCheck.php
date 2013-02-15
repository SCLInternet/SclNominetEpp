<?php
/**
 * Contains the nominet AbstractCheck response class definition.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */

namespace SclNominetEpp\Response\Check;

use SclNominetEpp\Response;

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
     * 
     * @param SimpleXMLElement $data
     * @todo Hey Tom, What's this return type?
     * @return type
     */
    public function processData($data)
    {
        if (!isset($data->response->resData)) {
            return;
        }

        $ns = $data->getNamespaces(true);

        $xmlValues = $data->response->resData->children($ns[$this->type]);

        $valueName = $this->valueName;
        foreach ($xmlValues->chkData->cd as $value) {
            $this->values[(string) $value->$valueName] = (boolean) (string) $value->$valueName->attributes()->avail;
        }
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
