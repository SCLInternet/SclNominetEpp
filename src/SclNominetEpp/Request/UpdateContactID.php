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

        $contactXSI   =   $contactNS . ' ' . 'contact-id-1.0.xsd';

        $update = $updateXML->addChild('contact-id:update', '', $contactNS);
        $update->addAttribute('xsi:schemaLocation', $contactXSI);
        $update->addChild(self::VALUE_NAME, $this->contact, self::UPDATE_NAMESPACE);

        $add = $update->addChild('add');
            $status = $add->addChild('status');
            $status->addAttribute('s', $s);
        $remove = $update->addChild('rem');
           
        $change = $update->addChild('chg');
            $postalInfo = $change->addChild('postalInfo');
            $postalInfo->addAttribute('type', $type);
                $postalInfo->addChild('name');
                $addr = $postalInfo->addChild('addr');
                    $addr->addChild('street');
                    $addr->addChild('city');
                    $addr->addChild('sp');
                    $addr->addChild('pc');
                    $addr->addChild('cc');
        //@todo implement all variables, also, fix the extension data.


    }

    public function setContact($contact)
    {
        $this->contact = $contact;
    }
}
