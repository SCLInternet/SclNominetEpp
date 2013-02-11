<?php

namespace SclNominetEpp\Request\Update;

use SclNominetEpp\Response\Update\Host as UpdateHostResponse;
use SclNominetEpp\Request;
use SclNominetEpp\Request\Update\Field\UpdateFieldInterface;

/**
 * This class build the XML for a Nominet EPP contact:update command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Host extends Request
{
    const TYPE = 'host'; //For possible Abstracting later
    const UPDATE_NAMESPACE = 'urn:ietf:params:xml:ns:host-1.0';

    const VALUE_NAME = 'name';

    protected $host = null;
    protected $value;
    
    private $add = array();
    private $remove = array();

    public function __construct($value)
    {
        parent::__construct('update', new UpdateHostResponse());
        $this->value = $value;
    }

    public function add(UpdateFieldInterface $field)
    {
        $this->add[] = $field;
    }

    public function remove(UpdateFieldInterface $field)
    {
        $this->remove[] = $field;
    }
    
    public function addContent(\SimpleXMLElement $updateXML)
    {
        $hostNS  = self::UPDATE_NAMESPACE;

        $hostXSI = $hostNS . ' ' . 'host-1.0.xsd';

        $update = $updateXML->addChild('host:update', '', $hostNS);
        $update->addAttribute('xsi:schemaLocation', $hostXSI);
        $update->addChild(self::VALUE_NAME, $this->value, $hostNS);

        if(!empty($this->add))
        {
            $addBlock = $update->addChild('add', '', $hostNS);
            foreach ($this->add as $field) {
                $field->fieldXml($addBlock, $hostNS);
            }
        }
       
        if(!empty($this->remove))
        {
            $remBlock = $updateXML->addChild('rem', '', $hostNS);
            foreach ($this->remove as $field) {
                $field->fieldXml($remBlock, $hostNS);
            }
        }

    }

    public function setContact($host)
    {
        $this->host = $host;
    }
}
