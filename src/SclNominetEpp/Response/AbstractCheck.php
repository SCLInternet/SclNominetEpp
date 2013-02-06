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
    
    public function __construct($type, $valueName)
    {
        $this->type = $type;
        $this->valueName = $valueName;
    }
    
    public function processData($data)
    {
        if (!isset($data->response->resData)) {
            return;
        }

        $ns = $data->getNamespaces(true);

        $this->values = $data->response->resData->children($ns[$this->type]);

        foreach ($this->values->chkData->cd as $value) {
            $this->values[(string)$value->valueName] = (boolean)(string)$value->valueName->attributes()->avail;
        }
    }

}
