<?php

namespace SclNominetEpp\Request\Create;

use InvalidArgumentException;
use SclNominetEpp\Contact as ContactObject;
use SclNominetEpp\Domain as DomainObject;
use SclNominetEpp\Nameserver;
use SclNominetEpp\Request;
use SclNominetEpp\Response;
use SimpleXMLElement;

/**
 * This class build the XML for a Nominet EPP create command.
 */
abstract class AbstractCreate extends Request
{
    /**
     * The type of check this is.
     */
    private string $type;

    /**
     * The namespace for the create command
     */
    private string $createNamespace;

    /**
     * The name of the identifier.
     */
    private string $valueName;

    /**
     * The object.
     * @var DomainObject|ContactObject|Nameserver|null
     */
    protected $object = null;

    public function __construct(string $type, string $createNamespace, string $valueName, Response $response = null)
    {
        parent::__construct('create', $response);

        $this->type = $type;
        $this->createNamespace = $createNamespace;
        $this->valueName = $valueName;
    }

    protected function addContent(SimpleXMLElement $action)
    {
        $this->objectValidate($this->object);

        $createNS  = $this->createNamespace;

        $create = $action->addChild("{$this->type}:create", '', $this->createNamespace);
        $create->addChild($this->valueName, $this->getName(), $createNS);

        $this->addSpecificContent($create);
    }

    abstract protected function getName();

    /**
     * Validates whether the object is of the correct class.
     * @throws InvalidArgumentException
     */
    abstract protected function objectValidate(object $object): bool;

    /**
     * This allows subclasses to add their own specific content
     * to the addContent function that all subclasses may run
     * because it is defined in this abstract class.
     */
    abstract protected function addSpecificContent(SimpleXMLElement $create);
}
