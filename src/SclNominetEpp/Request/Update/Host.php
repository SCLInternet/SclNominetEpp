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

    public function __construct(\SclNominetEpp\Nameserver $host)
    {
        parent::__construct('update', new UpdateHostResponse());
        $this->host = $host;
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
        $update->addChild(self::VALUE_NAME, $this->contact, $hostNS);

        $addBlock = $updateXML->addChild('add', '', $hostNS);
        
        foreach ($this->add as $field) {
            $field->addFieldXml($addBlock, $hostNS);
        }
        
        $remBlock = $updateXML->addChild('rem', '', $hostNS);
        
        foreach ($this->remove as $field) {
            $field->addFieldXml($remBlock, $hostNS);
        }
//        $add = $update->addChild('add');
//            $address = $add->addChild('addr');
//            $address->addAttribute('ip', $ipv);
//            $status  = $add->addChild('status');
//            $status->addAttribute('s', $s);
//        $remove = $update->addChild('rem');
//            $address = $add->addChild('addr');
//            $address->addAttribute('ip', $ipv);
//        $change = $update->addChild('chg');

    }

    public function setContact($contact)
    {
        $this->contact = $contact;
    }
}
