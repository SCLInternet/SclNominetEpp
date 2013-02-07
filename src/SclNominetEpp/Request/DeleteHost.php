<?php

namespace SclNominetEpp\Request;

use SclNominetEpp\Response\DeleteHost as DeleteHostResponse;

/**
 * This class build the XML for a Nominet EPP host:delete command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class DeleteHost extends Request{
    const TYPE = 'host'; //For possible Abstracting later
    const UPDATE_NAMESPACE = 'urn:ietf:params:xml:ns:delete-1.0';
    const VALUE_NAME = 'name';

    protected $host = '';
    protected $value;
    
    public function __construct($host)
    {
        parent::__construct('delete', new DeleteHostResponse());
        $this->host = $host;
    }

    public function addContent(SimpleXMLElement $updateXML)
    {
        $releaseNS  = self::UPDATE_NAMESPACE;

        $releaseXSI = $releaseNS . ' ' . 'delete-1.0.xsd';

        $update = $updateXML->addChild('host:delete', '', $releaseNS);
        $update->addAttribute('xsi:schemaLocation', $releaseXSI);
        $update->addChild(self::VALUE_NAME, $this->host, self::UPDATE_NAMESPACE);
    }
}
