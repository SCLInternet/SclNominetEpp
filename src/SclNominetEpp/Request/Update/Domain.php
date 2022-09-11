<?php

namespace SclNominetEpp\Request\Update;

use SclNominetEpp\Domain as DomainObject;
use SclNominetEpp\Request;
use SclNominetEpp\Request\Update\Field\UpdateFieldInterface;
use SclNominetEpp\Response\Update\Domain as UpdateDomainResponse;
use SimpleXMLElement;

/**
 * This class build the XML for a Nominet EPP domain:update command.
 */
class Domain extends Request
{
    const TYPE = 'domain'; //For possible Abstracting later
    const UPDATE_NAMESPACE = 'urn:ietf:params:xml:ns:domain-1.0';
    const UPDATE_EXTENSION_NAMESPACE = 'http://www.nominet.org.uk/epp/xml/domain-nom-ext-1.2';
    const VALUE_NAME = 'name';

    /** @var DomainObject */
    protected $domain = null;

    /** @var string Identifying value */
    protected $value;

    /** @var array An array of elements that will be added during the update command. */
    private $add = [];

    /** @var array An array of elements that will be removed during the update command. */
    private $remove = [];

    public function __construct(string $value)
    {
        parent::__construct('update', new UpdateDomainResponse());
        $this->value = $value;
    }

    /**
     * The add() function assigns a Field object as an element of the add array
     * for including specific fields in the update request "domain:add" tag.
     */
    public function add(UpdateFieldInterface $field)
    {
        $this->add[] = $field;
    }

    /**
     * The remove() function assigns a Field object as an element of the remove array
     * for including specific fields in the update request "domain:remove" tag.
     */
    public function remove(UpdateFieldInterface $field)
    {
        $this->remove[] = $field;
    }

    public function addContent(SimpleXMLElement $action)
    {
        $domainNS = self::UPDATE_NAMESPACE;
        $extensionNS = self::UPDATE_EXTENSION_NAMESPACE;

        $domainXSI = $domainNS . ' ' . 'domain-1.0.xsd';
        $extensionXSI = $extensionNS . ' ' . 'domain-nom-ext-1.2.xsd';

        $update = $action->addChild('domain:update', '', $domainNS);
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

        $extension->addChild('auto-bill');
        $extension->addChild('next-bill');
        $extension->addChild('notes');
        //@todo implement all variables, also, fix the extension data.
    }

    public function setDomain(DomainObject $domain)
    {
        $this->domain = $domain;
    }
}
