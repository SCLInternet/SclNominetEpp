<?php


namespace SclNominetEpp\Request;

use SclNominetEpp\Response\UpdateHost as UpdateHostResponse;

/**
 * This class build the XML for a Nominet EPP contact:update command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class UpdateHost
{
    const TYPE = 'host'; //For possible Abstracting later
    const UPDATE_NAMESPACE = 'urn:ietf:params:xml:ns:host-1.0';

    const VALUE_NAME = 'name';

    protected $contact = null;
    protected $value;

    public function __construct(Contact $contact)
    {
        parent::__construct('update', new UpdateContactResponse());
        $this->contact = $contact;
    }

    public function addContent(\SimpleXMLElement $updateXML)
    {
        $contactNS   = self::UPDATE_NAMESPACE;

        $contactXSI   =   $contactNS . ' ' . 'host-1.0.xsd';

        $update = $updateXML->addChild('host:update', '', $contactNS);
        $update->addAttribute('xsi:schemaLocation', $contactXSI);
        $update->addChild(self::VALUE_NAME, $this->contact, self::UPDATE_NAMESPACE);

        $add = $update->addChild('add');
            $address = $add->addChild('addr');
            $address->addAttribute('ip', $ipv);
            $status  = $add->addChild('status');
            $status->addAttribute('s', $s);
        $remove = $update->addChild('rem');
            $address = $add->addChild('addr');
            $address->addAttribute('ip', $ipv);
        $change = $update->addChild('chg');

    }

    public function setContact($contact)
    {
        $this->contact = $contact;
    }
}
