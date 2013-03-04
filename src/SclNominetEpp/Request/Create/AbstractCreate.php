<?php

/**
 * Contains the nominet AbstractCheck request class definition.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
namespace SclNominetEpp\Request\Create;

use SclNominetEpp\Request;
use SimpleXMLElement;
use Exception;

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
     * The domain|contact|host object.
     *
     * @var object
     */
    protected $object = null;

    /**
     * Constructor
     *
     * @param string $type
     * @param string $createNamespace
     * @param string $valueName
     * @param Response $response
     */
    public function __construct($type, $createNamespace, $valueName, Response $response = null)
    {
        parent::__construct('create', $response);

        $this->type = $type;
        $this->createNamespace = $createNamespace;
        $this->valueName = $valueName;
    }

    /**
     * {@inheritDoc}
     *
     * @param SimpleXMLElement $xml
     */
    protected function addContent(SimpleXMLElement $xml)
    {
        try {
            $this->objectValidate($this->object);
        } catch (Exception $e) {
            $e->getMessage();
        }

        $createNS  = $this->createNamespace;

        $createXSI = $createNS . ' ' . "{$this->type}-1.0.xsd";

        $create = $xml->addChild("{$this->type}:create", '', $this->createNamespace);
        //$create->addAttribute('xsi:schemaLocation', $createXSI);
        $create->addChild($this->valueName, $this->getName(), $createNS);

        $this->addSpecificContent($create);
    }

    abstract protected function getName();

    /**
     * Valdiates whether the object is of the correct class.
     *
     * @param object $object
     * @return boolean
     * @throws Exception
     */
    abstract protected function objectValidate($object);

    /**
     * This allows subclasses to add their own specific content
     * to the addContent function that all subclasses may run
     * because it is defined in this abstract class.
     *
     * @param SimpleXMLElement $create Create xml data.
     */
    abstract protected function addSpecificContent(SimpleXMLElement $create);
}
