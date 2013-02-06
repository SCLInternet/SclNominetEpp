<?php

namespace SclNominetEpp\Request;

use SclNominetEpp\Response\ReleaseDomain as ReleaseDomainResponse;

/**
 * This class build the XML for a Nominet EPP contact:update command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class ReleaseDomain
{
    const TYPE = 'domain'; //For possible Abstracting later
    const UPDATE_NAMESPACE = 'urn:ietf:params:xml:ns:release-1.0';
    const VALUE_NAME = 'domainName';

    protected $domain = '';
    protected $value;
    
    public function __construct($domain)
    {
        parent::__construct('update', new ReleaseDomainResponse());
        $this->domain = $domain;
    }

    public function addContent(SimpleXMLElement $updateXML)
    {
        $releaseNS  = self::UPDATE_NAMESPACE;

        $releaseXSI = $releaseNS . ' ' . 'release-1.0.xsd';

        $update = $updateXML->addChild('r:release', '', $releaseNS);
        $update->addAttribute('xsi:schemaLocation', $releaseXSI);
        $update->addChild(self::VALUE_NAME, $this->domain, self::UPDATE_NAMESPACE);
        $update->addChild('registrarTag', $releasedTo);
    }
}
