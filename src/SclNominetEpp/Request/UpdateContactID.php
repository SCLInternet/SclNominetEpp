<?php


namespace SclNominetEpp\Request;

use SclNominetEpp\Response\UpdateContact as UpdateContactResponse;

/**
 * This class build the XML for a Nominet EPP contact:update command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class UpdateContact
{
    const TYPE = 'contact'; //For possible Abstracting later
    const UPDATE_NAMESPACE = 'urn:ietf:params:xml:ns:contact-1.0';

    const VALUE_NAME = 'id';

    protected $newContactID = null;
    protected $value;

    public function __construct($newContactID)
    {
        parent::__construct('update', new UpdateContactResponse());
        $this->newContactID = $newContactID;
    }

    public function addContent(SimpleXMLElement $updateXML)
    {
        $contactNS   = self::UPDATE_NAMESPACE;

        $contactXSI   =   $contactNS . ' ' . 'contact-id-1.0.xsd';

        $update = $updateXML->addChild('contact-id:update', '', $contactNS);
        $update->addAttribute('xsi:schemaLocation', $contactXSI);
        $update->addChild(self::VALUE_NAME, $this->contactID, self::UPDATE_NAMESPACE);
        $change = $update->addChild('chg');
        $change->addChild(self::VALUE_NAME, $this->newContactID);
    }

    public function setContactID($contactID)
    {
        $this->contactID = $contactID;
    }
}
