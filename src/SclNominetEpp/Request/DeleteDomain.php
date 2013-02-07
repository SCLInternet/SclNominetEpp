<?php

namespace SclNominetEpp\Request;

use SclNominetEpp\Response\DeleteDomain as DeleteDomainResponse;

/**
 * This class build the XML for a Nominet EPP domain:delete command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class DeleteDomain extends Request
{
    const TYPE = 'domain'; //For possible Abstracting later
    const UPDATE_NAMESPACE = 'urn:ietf:params:xml:ns:delete-1.0';
    const VALUE_NAME = 'name';

    protected $domain = '';
    protected $value;
    
    public function __construct($domain)
    {
        parent::__construct('delete', new DeleteDomainResponse());
        $this->domain = $domain;
    }

    public function addContent(SimpleXMLElement $updateXML)
    {
        $releaseNS  = self::UPDATE_NAMESPACE;

        $releaseXSI = $releaseNS . ' ' . 'delete-1.0.xsd';

        $update = $updateXML->addChild('domain:delete', '', $releaseNS);
        $update->addAttribute('xsi:schemaLocation', $releaseXSI);
        $update->addChild(self::VALUE_NAME, $this->domain, self::UPDATE_NAMESPACE);
    }
}
