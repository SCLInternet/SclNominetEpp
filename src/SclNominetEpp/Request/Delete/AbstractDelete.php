<?php

namespace SclNominetEpp\Request\Delete;

use SclNominetEpp\Request;

/**
 * This class build the XML for a Nominet EPP delete command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class AbstractDelete extends Request
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
    private $deleteNamespace;

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
    public function __construct($type, $response, $deleteNamespace, $valueName)
    {
        parent::__construct('delete', $response);

        $this->type            = $type;
        $this->deleteNamespace = $deleteNamespace;
        $this->valueName       = $valueName;
    }

    /**
     * (non-PHPdoc)
     * @see SclNominetEpp\Request.AbstractRequest::addContent()
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
