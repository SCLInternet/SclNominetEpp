<?php

namespace SclNominetEpp\Request\Release;

use SclNominetEpp\Request;

/**
 * This class build the XML for a Nominet EPP r:release command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
abstract class AbstractRelease extends Request
{
    /**
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
     *
     * @var string
     */
    private $updateNamespace;

    /**
     *
     * @var string
     */
    private $valueName;
    
    public function __construct($type, $response, $updateNamespace, $valueName)
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
    public function setValue($value)
    {
        $this->value = $value;
    }
    
    public function setRegistrarTag($registrarTag)
    {
        $this->registrarTag = $registrarTag;
    }
    
    /**
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
