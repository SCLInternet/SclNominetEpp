<?php

namespace SclNominetEpp\Request\Update;

use SclNominetEpp\Domain as DomainObject;
use SclNominetEpp\Request;
use SclNominetEpp\Contact as ContactObject;
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
    const UPDATE_EXTENSION_NAMESPACE = 'http://www.nominet.org.uk/epp/xml/domain-nom-ext-1.1';
    const VALUE_NAME = 'name';

    /** @var DomainObject */
    protected $domain = null;

    /** @var string Identifying value */
    protected $value;

    /** @var array An array of elements that will be added during the update command. */
    private $add = [];

    /** @var array An array of elements that will be removed during the update command. */
    private $remove = [];

    /** @var ?ContactObject */
    private $registrant;

    /** @var ?string */
    private $password;

    /** @var array */
    private $notes = [];

    /**
     * The number of days before expiry you wish to automatically renew a domain name.
     * Values between 1-182.
     * This field can be cleared by setting the default value of 0.
     * Auto-bill cannot be set if next-bill, recur-bill or renew-not-required are set.
     *
     * @var int
     */
    private $autoBill;

    /**
     * The number of days before expiry you wish to automatically renew a domain name.
     * The next-bill field will reset to 0 after a single registration period.
     * Values between 1 and 182, indicating how many days before expiry you wish to renew the domain name.
     * This field can be cleared by setting the default value of 0.
     * Next-bill cannot be set if auto-bill, recur-bill or renew-not-required are set.
     *
     * @var int
     */
    private $nextBill;

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
        $extensionXSI = $extensionNS . ' ' . 'domain-nom-ext-1.1.xsd';

        $update = $action->addChild('domain:update', '', $domainNS);
        $update->addChild(self::VALUE_NAME, $this->value, $domainNS);
        $update->addAttribute(
            'xsi:schemaLocation',
            $domainXSI,
            self::XSI_NAMESPACE,
        );

        $addBlock = $update->addChild('add', '', $domainNS);

        $nameservers = $addBlock->addChild('ns', '', $domainNS);
        foreach ($this->add as $field) {
            $xml = $field instanceof Request\Update\Field\DomainNameserver ? $nameservers : $addBlock;
            $field->fieldXml($xml);
        }

        $remBlock = $update->addChild('rem', '', $domainNS);
        $nameservers = $remBlock->addChild('ns', '', $domainNS);
        foreach ($this->remove as $field) {
            $xml = $field instanceof Request\Update\Field\DomainNameserver ? $nameservers : $addBlock;
            $field->fieldXml($xml);
        }

        $change = $update->addChild('chg');
        $domainRegistrant = new Request\Update\Field\DomainRegistrant($this->registrant, $this->password);
        $domainRegistrant->fieldXml($change);

        $extensionXML = $this->xml->command->addChild('extension');
        $extension = $extensionXML->addChild('domain-ext:update', '', $extensionNS);
        $extension->addAttribute(
            'xsi:schemaLocation',
            $extensionXSI,
            self::XSI_NAMESPACE,
        );

        $extension->addChild('auto-bill', $this->autoBill);
        $extension->addChild('next-bill', $this->nextBill);
        foreach ($this->notes as $note) {
            $extension->addChild('notes', $note);
        }
    }

    public function setDomain(DomainObject $domain)
    {
        $this->domain = $domain;
    }

    public function changeRegistrant(ContactObject $contact)
    {
        $this->registrant = $contact;
    }

    public function setAutoBill(int $autoBill): void
    {
        $this->autoBill = $autoBill;
    }

    /**
     * @param string|null $password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    public function addNote(string $note): void
    {
        $this->notes[] = $note;
    }

    /**
     * @param int $nextBill
     */
    public function setNextBill(int $nextBill): void
    {
        $this->nextBill = $nextBill;
    }
}
