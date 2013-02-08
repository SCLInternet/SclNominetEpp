<?php
/**
 * Contains the nominet AbstractCheck request class definition.
 *
 * @author Tom Oram <tom@scl.co.uk>
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */

namespace SclNominetEpp\Request\Check;

use SclNominetEpp\Request;

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
     *
     * @var string
     */
    private $checkNamespace;

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

    /**
     * Tells the parent class what the action of this request is.
     *
     * @param  string     $type
     * @throws \Exception
     */
    public function __construct($type, $response, $checkNamespace, $valueName)
    {
        parent::__construct('check', $response);

        $this->type = $type;
        $this->checkNamespace = $checkNamespace;
        $this->valueName = $valueName;
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
