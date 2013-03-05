<?php
/**
 * Contains the nominet AbstractCheck request class definition.
 *
 * @author Tom Oram <tom@scl.co.uk>
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */

namespace SclNominetEpp\Request\Check;

use SclNominetEpp\Request;
use SclNominetEpp\Response;

/**
 * This class build the XML for a Nominet EPP check command.
 *
 * @author Tom Oram <tom@scl.co.uk>
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
abstract class AbstractCheck extends Request
{
    /**
     * The type of check this is.
     *
     * @var string
     */
    private $type;

    /**
     * The namespace for the Nominet EPP check request.
     *
     * @var string
     */
    private $checkNamespace;

    /**
     * The name of the identifying value for the check request
     * (e.g. name or id)
     *
     * @var string
     */
    private $valueName;

    /**
     *
     * @var array
     */
    private $values = array();

    /**
     * Constructor.
     *
     * @param string $type
     * @param string $checkNamespace
     * @param string $valueName
     * @param Response $response
     */
    public function __construct($type, $checkNamespace, $valueName, Response $response = null)
    {
        parent::__construct('check', $response);

        $this->type           = $type;
        $this->checkNamespace = $checkNamespace;
        $this->valueName      = $valueName;
    }

    /**
     * The values to lookup.
     *
     * @param  array|string $values
     * @return Check
     */
    public function lookup($values)
    {
        if (is_array($values)) {
            $this->values = $values;
        } else {
            $this->values = array($values);
        }

        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see SclNominetEpp\Request.AbstractRequest::addContent()
     */
    protected function addContent(\SimpleXMLElement $xml)
    {
        $check = $xml->addChild("{$this->type}:check", '', $this->checkNamespace);

        foreach ($this->values as $value) {
            $check->addChild($this->valueName, $value, $this->checkNamespace);
        }
    }
}
