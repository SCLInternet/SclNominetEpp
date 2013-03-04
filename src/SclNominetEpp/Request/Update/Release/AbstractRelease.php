<?php

namespace SclNominetEpp\Request\Update\Release;

use SclNominetEpp\Request;
use SimpleXMLElement;

/**
 * This class build the XML for a Nominet EPP r:release command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
abstract class AbstractRelease extends Request
{
    /**
     * The value of the check Identifier.
     *
     * @var string
     */
    protected $value='';

    /**
     * The type of check this is.
     *
     * @var string
     */
    private $type;

    /**
     * The namespace of update
     *
     * @var string
     */
    private $updateNamespace;

    /**
     * The name of the check Identifier (e.g. 'id', 'name')
     *
     * @var string
     */
    private $valueName;

    /**
     * This is the tag the domain name is currently on.
     * When used with a release or transfer operation,
     * this is the tag of the registrar receiving the domain name.
     *
     * @var mixed
     */
    private $registrarTag;

    /**
     * Constructor
     *
     * @param string $type
     * @param string $updateNamespace
     * @param string $valueName
     * @param SimpleXMLElement $response
     */
    public function __construct($type, $updateNamespace, $valueName, $response = null)
    {
        parent::__construct('update', $response);
        $this->type  = $type;
        $this->updateNamespace = $updateNamespace;
        $this->valueName = $valueName;
    }

    /**
     * SetValue
     *
     * @param  string $value
     */
    public function lookup($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Set the tag for the current demain name
     *
     * @param type $registrarTag
     */
    public function setRegistrarTag($registrarTag)
    {
        $this->registrarTag = $registrarTag;
    }

    /**
     * Add content to the request form.
     *
     * @param \SimpleXMLElement $updateXML
     */
    public function addContent(\SimpleXMLElement $updateXML)
    {
        $releaseNS  = $this->updateNamespace;

        $releaseXSI = $releaseNS . ' ' . 'release-1.0.xsd';

        $update = $updateXML->addChild('r:release', '', $releaseNS);
        $update->addAttribute('xsi:schemaLocation', $releaseXSI);
        $update->addChild($this->valueName, $this->value, $releaseNS);
        $update->addChild('registrarTag', $this->registrarTag);
    }
}
