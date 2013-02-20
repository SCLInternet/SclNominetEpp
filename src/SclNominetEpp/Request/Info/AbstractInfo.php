<?php
/**
 * Contains the nominet AbstractInfo request class definition.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */

namespace SclNominetEpp\Request\Info;

use SclNominetEpp\Request;
use SimpleXMLElement;

/**
 * This class build the XML for a Nominet EPP info command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
abstract class AbstractInfo extends Request
{

    /**
     * The namespace for the Nominet EPP info request.
     * 
     * @var string
     */
    protected $infoNamespace;

    /**
     * The name of the identifying value for the info request
     * (e.g. name or id)
     * 
     * @var string
     */
    protected $valueName;

    /**
     * The value of the identifier of the info request.
     *
     * @var type
     */
    protected $value;

    /**
     * Constructor
     * 
     * @param string $type
     * @param string $infoNamespace
     * @param string $valueName
     * @param SimpleXMLElement $response
     */
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
     * addContent
     * @todo An actual description
     * 
     * @param \SimpleXMLElement $xml
     */
    protected function addContent(\SimpleXMLElement $xml)
    {
        $info = $xml->addChild("{$this->type}:info", '', $this->infoNamespace);

        $info->addChild($this->valueName, $this->value, $this->infoNamespace);
    }
}
