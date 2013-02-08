<?php

namespace SclNominetEpp\Request\Release;

use SclNominetEpp\Response\Release\Contact as ReleaseContactResponse;
use SclNominetEpp\Request;

/**
 * This class build the XML for a Nominet EPP r:release command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Contact extends Request
{
    const TYPE = 'contact'; //For possible Abstracting later
    const UPDATE_NAMESPACE = 'urn:ietf:params:xml:ns:release-1.0';
    const VALUE_NAME = 'registrant';

    protected $registrant = '';
    protected $value;
    
    public function __construct($registrant)
    {
        parent::__construct('update', new ReleaseContactResponse());
        $this->registrant = $registrant;
    }

    public function addContent(SimpleXMLElement $updateXML)
    {
        $releaseNS  = self::UPDATE_NAMESPACE;

        $releaseXSI = $releaseNS . ' ' . 'release-1.0.xsd';

        $update = $updateXML->addChild('r:release', '', $releaseNS);
        $update->addAttribute('xsi:schemaLocation', $releaseXSI);
        $update->addChild(self::VALUE_NAME, $this->registrant, self::UPDATE_NAMESPACE);
        $update->addChild('registrarTag', $releasedTo);
    }
}
