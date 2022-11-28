<?php

namespace SclNominetEpp\Request\Check;

use SclNominetEpp\Request;
use SclNominetEpp\Response;
use SimpleXMLElement;

/**
 * This class build the XML for a Nominet EPP check command.
 */
abstract class AbstractCheck extends Request
{
    /**
     * The type of check this is.
     */
    private string $type;

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
     */
    public function lookup($values): AbstractCheck
    {
        if (is_array($values)) {
            $this->values = $values;
        } else {
            $this->values = array($values);
        }

        return $this;
    }

    protected function addContent(SimpleXMLElement $action)
    {
        $check = $action->addChild("{$this->type}:check", '', $this->checkNamespace);

        foreach ($this->values as $value) {
            $check->addChild($this->valueName, $value, $this->checkNamespace);
        }
    }
}
