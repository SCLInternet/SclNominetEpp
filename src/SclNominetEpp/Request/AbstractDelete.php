<?php

namespace SclNominetEpp\Request;

/**
 * This class build the XML for a Nominet EPP delete command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class AbstractDelete extends Request
{
    const TYPE = 'contact'; //For possible Abstracting later
    const UPDATE_NAMESPACE = 'urn:ietf:params:xml:ns:delete-1.0';
    const VALUE_NAME = 'id';

    protected $contact = '';
    protected $value;
    
    public function __construct($contact)
    {
        parent::__construct('delete', new DeleteContactResponse());
        $this->contact = $contact;
    }

    public function addContent(SimpleXMLElement $updateXML)
    {
        $releaseNS  = self::UPDATE_NAMESPACE;

        $releaseXSI = $releaseNS . ' ' . 'delete-1.0.xsd';

        $update = $updateXML->addChild('contact:delete', '', $releaseNS);
        $update->addAttribute('xsi:schemaLocation', $releaseXSI);
        $update->addChild(self::VALUE_NAME, $this->contact, self::UPDATE_NAMESPACE);
    }
}
