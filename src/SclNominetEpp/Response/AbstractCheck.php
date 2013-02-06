<?php
/**
 * Contains the nominet AbstractCheck response class definition.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */

namespace SclNominetEpp\Response;
/**
 * This class interprets XML for a Nominet EPP check command response.
 * 
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class AbstractCheck extends Response
{
    /**
     * The type of check this is.
     *
     * @var string
     */
    private $type;

    /**
     *
     * @var string
     */
    private $valueName;

    /**
     *
     * @var array
     */
    private $values = array();
    
    public function __construct($data = null)
    {
        parent::__construct($data);
    }
    
    public function processData($data)
    {
        if (!isset($data->response->resData)) {
            return;
        }

        $ns = $data->getNamespaces(true);

        $this->values = $data->response->resData->children($ns[$this->type]);

        $valueName = $this->valueName;
        foreach ($this->values->chkData->cd as $value) {
            $avail = (string)$value->{$valueName}->attributes()->avail;
            echo $avail;
            $this->values[(string)$value->$valueName] = (boolean)$avail;
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

    /**
     * Set $this->type
     *
     * @param string $type
     */
    protected function setType($type) {
        $this->type = $type;
    }

    /**
     * Get $this->type
     *
     * @return string
     */
    protected function getType() {
        return $this->type;
    }
    
    /**
     * Set $this->valueName
     *
     * @param string $valueName
     */
    public function setValueName($valueName) {
        $this->valueName = $valueName;
    }

    /**
     * Get $this->valueName
     *
     * @return string
     */
    public function getValueName() {
        return $this->valueName;
    }
    
}
