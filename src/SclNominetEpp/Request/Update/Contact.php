<?php

namespace SclNominetEpp\Request\Update;

use SclNominetEpp\Response\Update\Contact as UpdateContactResponse;
use SclNominetEpp\Request;

/**
 * This class build the XML for a Nominet EPP contact:update command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Contact extends Request
{
    const TYPE = 'contact'; //For possible Abstracting later
    const UPDATE_NAMESPACE = 'urn:ietf:params:xml:ns:contact-1.0';
    const UPDATE_EXTENSION_NAMESPACE = 'http://www.nominet.org.uk/epp/xml/contact-nom-ext-1.1';

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
        $extensionNS = self::UPDATE_EXTENSION_NAMESPACE;

        $contactXSI   =   $contactNS . ' ' . 'contact-1.0.xsd';
        $extensionXSI = $extensionNS . ' ' . 'contact-nom-ext-1.1.xsd';

        $update = $updateXML->addChild('contact:update', '', $contactNS);
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
        $extensionXML = $this->xml->command->addChild('extension');
        $extension = $extensionXML->addChild('contact-nom-ext:update', '', $extensionNS);
        $extension->addAttribute('xsi:schemaLocation', $extensionXSI);

        $extension->addChild('trad-name');
        $extension->addChild('type');
        $extension->addChild('co-no');
        $extension->addChild('opt-out');
        //@todo implement all variables, also, fix the extension data.

    }

    public function setContact($contact)
    {
        $this->contact = $contact;
    }
}
