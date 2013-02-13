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
    
    /**
     * An array of elements that will be added during the update command.
     * 
     * @var array
     */
    private $add = array();
    
    /**
     * An array of elements that will be removed during the update command. 
     * 
     * @var array
     */
    private $remove = array();

    public function __construct($value)
    {
        parent::__construct('update', new UpdateDomainResponse());
        $this->value = $value;
    }

    /**
     * The <b>add()</b> function assigns a Field object as an element of the add array
     * for including specific fields in the update request "domain:add" tag.
     * 
     * @param \SclNominetEpp\Request\Update\Field\UpdateFieldInterface $field
     */
    public function add(UpdateFieldInterface $field)
    {
        $this->add[] = $field;
    }

    /**
     * /**
     * The <b>remove()</b> function assigns a Field object as an element of the remove array
     * for including specific fields in the update request "domain:remove" tag.
     * 
     * @param \SclNominetEpp\Request\Update\Field\UpdateFieldInterface $field
     */
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
        $update->addChild(self::VALUE_NAME, $this->value, $domainNS);

        $addBlock = $update->addChild('add', '', $domainNS);
        
        foreach ($this->add as $field) {
            $field->fieldXml($addBlock, $domainNS);
        }
        
        $remBlock = $update->addChild('rem', '', $domainNS);
        
        foreach ($this->remove as $field) {
            $field->fieldXml($remBlock, $domainNS);
        }
        
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
