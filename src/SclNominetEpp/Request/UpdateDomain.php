<?php

namespace SclNominetEpp\Request;

use SclNominetEpp\Response\UpdateDomain as UpdateDomainResponse;

/**
 * This class build the XML for a Nominet EPP domain:update command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class UpdateDomain extends Request
{
    const TYPE = 'domain'; //For Abstracting later
    const UPDATE_NAMESPACE = 'urn:ietf:params:xml:ns:domain-1.0';
    const UPDATE_EXTENSION_NAMESPACE = 'http://www.nominet.org.uk/epp/xml/domain-nom-ext-1.1';

    const VALUE_NAME = 'name';

    protected $domain = null;
    protected $value;

    public function __construct(Domain $domain)
    {
        parent::__construct('update', new UpdateDomainResponse());
        $this->domain = $domain;
    }

    public function addContent(\SimpleXMLElement $updateXML)
    {
        $domainNS  = self::UPDATE_NAMESPACE;
        $extensionNS = self::UPDATE_EXTENSION_NAMESPACE;

        $domainXSI    =    $domainNS . ' ' . ' domain-1.0.xsd';
        $extensionXSI = $extensionNS . ' ' . 'domain-nom-ext-1.1.xsd';

        $update = $updateXML->addChild('domain:update', '', $domainNS);
        $update->addAttribute('xsi:schemaLocation', $domainXSI);
        $update->addChild(self::VALUE_NAME, $this->domain, self::UPDATE_NAMESPACE);

        $add = $update->addChild('add');
            $add->addChild('ns');
            $add->addChild('contact');
            $add->addChild('status');

        $remove = $update->addChild('rem');
            $remove->addChild('ns');
            $remove->addChild('contact');
            $remove->addChild('status');
        $change = $update->addChild('chg');
            $change->addChild('registrant');
            $authInfo = $change->addChild('authInfo');
                $authInfo->addChild('pw');

        $extensionXML = $this->xml->command->addChild('extension');
        $extension = $extensionXML->addChild('domain-nom-ext:update', '', $extensionNS);
        $extension->addAttribute('xsi:schemaLocation', $extensionXSI);

        $extension->addChild('first-bill');
        $extension->addChild('recur-bill');
        $extension->addChild('auto-bill');
        $extension->addChild('next-bill');
        $extension->addChild('notes');
        //@todo implement all variables, also, fix the extension data.


    }

    public function setDomain()
    {
        $this->domain = $domain;
    }
}
