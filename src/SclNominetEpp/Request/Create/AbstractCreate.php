<?php

/**
 * Contains the nominet AbstractCheck request class definition.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
namespace SclNominetEpp\Request\Create;

use SclNominetEpp\Request;
use SimpleXMLElement;

/**
 * This class build the XML for a Nominet EPP create command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
abstract class AbstractCreate extends Request
{
    /**
     * The type of check this is.
     *
     * @var string
     */
    private $type;

    /**
     * The namespace for the create command
     * 
     * @var string
     */
    private $createNamespace;

    /**
     * The name of the identifier.
     * 
     * @var string
     */
    private $valueName;

    /**
     * The value of the identifier.
     * 
     * @var string
     */
    private $value;
    
    /**
     * Constructor
     *
     * @param string $type
     * @param string $createNamespace
     * @param string $valueName
     * @param string $value
     * @param SimpleXMLElement $response
     */
    public function __construct($type, $createNamespace, $valueName, $response = null)
    {
        parent::__construct('create', $response);

        $this->type = $type;
        $this->createNamespace = $createNamespace;
        $this->valueName = $valueName;
    }

    /**
     * (non-PHPdoc)
     * @see SclNominetEpp\Request.AbstractRequest::addContent()
     */
    protected function addContent(\SimpleXMLElement $xml)
    {
        try{
            $this->objectValidate();
        } catch (Exception $e) {
            echo "Message:" . $e->getMessage();
        }
        $createNS  = $this->createNamespace;

        $createXSI = $createNS . ' ' . "{$this->type}-1.0.xsd";
        
        $create = $xml->addChild("{$this->type}:create", '', $this->createNamespace);
        $create->addAttribute('xsi:schemaLocation', $createXSI);
        $create->addChild($this->valueName, $this->value, $createXSI);
        
        $this->addSpecificContent($create);
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
     * Valdiates whether the object is of the correct class.
     * 
     */
    abstract protected function objectValidate();
    
    /**
     * This allows subclasses to add their own specific content
     * to the addContent function that all subclasses may run
     * because it is defined in this abstract class.
     * 
     * @param SimpleXMLElement $create Create xml data.
     */
    abstract protected function addSpecificContent(SimpleXMLElement $create);
}
