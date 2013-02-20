<?php

namespace SclNominetEpp\Request\Delete;

use SclNominetEpp\Request;
use SimpleXMLElement;

/**
 * This class build the XML for a Nominet EPP delete command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
abstract class AbstractDelete extends Request
{
    /**
     * The type of delete this is.
     *
     * @var string
     */
    private $type;

    /**
     * The Namespace of the delete
     * 
     * @var string
     */
    private $deleteNamespace;

    /**
     * The valuename of the specific object for deletion
     * 
     * @var string
     */
    private $valueName;

    /**
     * The value of the specific object for deletion
     * 
     * @var string
     */
    private $value;

    /**
     * Tells the parent class what the action of this request is.
     * 
     * @param string $type
     * @param string $deleteNamespace
     * @param string $valueName
     * @param SimpleXMLElement $response
     */
    public function __construct($type, $deleteNamespace, $valueName, $response = null)
    {
        parent::__construct('delete', $response);

        $this->type            = $type;
        $this->deleteNamespace = $deleteNamespace;
        $this->valueName       = $valueName;
    }

    /**
     * The value to lookup.
     *
     * @param  string $value
     * @return Info
     */
    public function lookup($value)
    {
        $this->value = $value;

        return $this;
    }
    
    /**
     * addContent
     * @todo An actual description
     * @param SimpleXMLElement $deleteXML
     */
    public function addContent(SimpleXMLElement $deleteXML)
    {
        $deleteNS  = $this->deleteNamespace;

        $deleteXSI = $deleteNS . ' ' . "{$this->type}-1.0.xsd";

        $delete = $deleteXML->addChild("{$this->type}:delete", '', $deleteNS);
        $delete->addAttribute('xsi:schemaLocation', $deleteXSI);
        $delete->addChild($this->valueName, $this->value, $deleteNS);
    }
}
