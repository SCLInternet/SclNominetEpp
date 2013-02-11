<?php
/**
 * Contains the nominet AbstractInfo request class definition.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */

namespace SclNominetEpp\Request\Info;

use SclNominetEpp\Request;

/**
 * This class build the XML for a Nominet EPP info command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class AbstractInfo extends Request
{

    /**
     *
     * @var string
     */
    protected $infoNamespace;

    /**
     *
     * @var string
     */
    protected $valueName;

    /**
     *
     * @var type
     */
    protected $value;

    public function __construct($type, $infoNamespace, $valueName, $response = null)
    {

        parent::__construct('info', $response);
        $this->type = $type;
        $this->valueName = $valueName;
        $this->infoNamespace = $infoNamespace;
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
     * (non-PHPdoc)
     * @see SclNominetEpp\Request.AbstractRequest::addContent()
     */
    protected function addContent(\SimpleXMLElement $xml)
    {
        $info = $xml->addChild("{$this->type}:info", '', $this->infoNamespace);

        $info->addChild($this->valueName, $this->value, $this->infoNamespace);
    }
    
    
}
