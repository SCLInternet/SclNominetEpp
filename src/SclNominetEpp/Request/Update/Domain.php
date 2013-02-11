<?php

namespace SclNominetEpp\Request\Update;

use SclNominetEpp\Response\Update\Domain as UpdateDomainResponse;
use SclNominetEpp\Request;
use SclNominetEpp\Request\Update\Field\UpdateFieldInterface;

/**
 * This class build the XML for a Nominet EPP domain:update command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Domain extends Request
{
    const TYPE = 'domain'; //For possible Abstracting later
    const UPDATE_NAMESPACE = 'urn:ietf:params:xml:ns:domain-1.0';
    const UPDATE_EXTENSION_NAMESPACE = 'http://www.nominet.org.uk/epp/xml/domain-nom-ext-1.1';

    const VALUE_NAME = 'name';

    protected $domain = null;
    protected $value;
    
    private $add = array();
    private $remove = array();

    public function __construct(Domain $domain)
    {
        parent::__construct('update', new UpdateDomainResponse());
        $this->domain = $domain;
    }

    public function add(UpdateFieldInterface $field)
    {
        $this->add[] = $field;
    }

    public function remove(UpdateFieldInterface $field)
    {
        $this->remove[] = $field;
    }
    
    public function addContent(\SimpleXMLElement $updateXML)
    {
        $domainNS    = self::UPDATE_NAMESPACE;
        $extensionNS = self::UPDATE_EXTENSION_NAMESPACE;

        $domainXSI    =    $domainNS . ' ' . 'domain-1.0.xsd';
        $extensionXSI = $extensionNS . ' ' . 'domain-nom-ext-1.1.xsd';

        $update = $updateXML->addChild('domain:update', '', $domainNS);
        $update->addAttribute('xsi:schemaLocation', $domainXSI);
        $update->addChild(self::VALUE_NAME, $this->domain, $domainNS);

        $addBlock = $updateXML->addChild('add', '', $domainNS);
        
        foreach ($this->add as $field) {
            $field->addFieldXml($addBlock, $domainNS);
        }
        
        $remBlock = $updateXML->addChild('rem', '', $domainNS);
        
        foreach ($this->remove as $field) {
            $field->addFieldXml($remBlock, $domainNS);
        }
        
        //$add = $update->addChild('add');
        //$add->addChild('ns');
        //$add->addChild('contact');
        //$add->addChild('status');
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

    public function setDomain($domain)
    {
        $this->domain = $domain;
    }
}
