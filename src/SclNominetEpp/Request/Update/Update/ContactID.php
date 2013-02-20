<?php

namespace SclNominetEpp\Request\Update\Update;

use SclNominetEpp\Response\Update\Update\UpdateContactID as UpdateContactIDResponse;
use SclNominetEpp\Request;
use SclNominetEpp\Request\Update\Update\Field\UpdateFieldInterface;

/**
 * This class build the XML for a Nominet EPP contact:update command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class ContactID extends Request
{
    const TYPE = 'contact'; //For possible Abstracting later
    const UPDATE_NAMESPACE = 'urn:ietf:params:xml:ns:contact-1.0';

    const VALUE_NAME = 'id';

    protected $newContactID = null;
    protected $value;
    
    private $add = array();
    private $remove = array();

    public function __construct($value)
    {
        parent::__construct('update', new UpdateContactIDResponse());
        $this->value = $value;
    }

    /**
     * The <b>add()</b> function assigns a Field object as an element of the add array
     * for including specific fields in the update request "contactID:add" tag.
     * 
     * @param \SclNominetEpp\Request\Update\Field\UpdateFieldInterface $field
     */
    public function add(UpdateFieldInterface $field)
    {
        $this->add[] = $field;
    }

    /**
     * The <b>remove()</b> function assigns a Field object as an element of the remove array
     * for including specific fields in the update request "contactID:remove" tag.
     * 
     * @param \SclNominetEpp\Request\Update\Field\UpdateFieldInterface $field
     */
    public function remove(UpdateFieldInterface $field)
    {
        $this->remove[] = $field;
    }
    
    public function addContent(SimpleXMLElement $updateXML)
    {
        $contactNS   = self::UPDATE_NAMESPACE;

        $contactXSI   =   $contactNS . ' ' . 'contact-id-1.0.xsd';

        $update = $updateXML->addChild('contact-id:update', '', $contactNS);
        $update->addAttribute('xsi:schemaLocation', $contactXSI);
        $update->addChild(self::VALUE_NAME, $this->contactID, self::UPDATE_NAMESPACE);
        $change = $update->addChild('chg');
        $change->addChild(self::VALUE_NAME, $this->value);
    }

    public function setContactID($contactID)
    {
        $this->contactID = $contactID;
    }
}
