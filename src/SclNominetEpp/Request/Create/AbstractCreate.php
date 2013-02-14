<?php

/**
 * Contains the nominet AbstractCheck request class definition.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
namespace SclNominetEpp\Request\Create;

use SclNominetEpp\Request;

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
     *
     * @var string
     */
    private $createNamespace;

    /**
     *
     * @var string
     */
    private $valueName;

    /**
     *
     * @var string
     */
    private $value;
    
    /**
     * Tells the parent class what the action of this request is.
     *
     * @param  string     $type
     * @throws \Exception
     */
    public function __construct($type, $response, $createNamespace, $valueName)
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
        if (!$this->contact instanceof ContactObject) {
            $exception = sprintf('A valid contact object was not passed to CreateContact, Ln:%d', __LINE__);
            throw new Exception($exception);
        }
        
        $createNS  = $this->createNamespace;

        $createXSI = $createNS . ' ' . "{$this->type}-1.0.xsd";

        $create = $xml->addChild("{$this->type}:create", '', $this->createNamespace);
        $create->addAttribute('xsi:schemaLocation', $createXSI);
        $create->addChild($this->valueName, $this->value, $createXSI);
        
        $this->addSpecificContent();
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
    
    public function addSpecificContent()
    {
        
    }
    
    
}
