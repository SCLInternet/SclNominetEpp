<?php

namespace SclNominetEpp\Response\Info;

use SclNominetEpp\Contact as ContactObject;
use SclNominetEpp\Domain as DomainObject;
use SclNominetEpp\Nameserver;
use SclNominetEpp\Response;
use SimpleXMLElement;
use DateTime;

/**
 * This class interprets XML for a Nominet EPP info command response.
 */
abstract class AbstractInfo extends Response
{
    /** @var DomainObject|ContactObject|Nameserver|null */
    protected $object;
    private string $valueName;
    private string $type;

    /**
     * Constructor
     *
     * @param DomainObject|ContactObject|Nameserver|null $object
     */
    public function __construct(string $type, $object, string $valueName)
    {
        $this->type = $type;
        $this->object = $object;
        $this->valueName = $valueName;
    }

    /**
     * @throws \Exception
     */
    public function processData(SimpleXMLElement $xml)
    {
        if (!$this->success()) {
            return;
        }
        if (!$this->xmlValid($xml)) {
            return;
        }
        $name = $this->valueName;
        $ns = $xml->getNamespaces(true);
        $response = $xml->response;

        $infData = $response->resData->children($ns[$this->type])->infData;
        if (isset($ns["{$this->type}-nom-ext"])) {
            $extension = $response->extension->children($ns["{$this->type}-nom-ext"])->infData;
        }
        $this->setValue($infData->$name);

        $this->object->setClientID($infData->clID);
        $crDate = (string) $infData->crDate;
        $this->object->setCreated($crDate ? new DateTime($crDate) : null);
        $upDate = (string) $infData->upDate;
        $this->object->setUpDate($upDate ? new DateTime($upDate) : null);

        if (!isset($extension)) {
            $this->addSpecificData($infData);
        } else {
            $this->addSpecificData($infData, $extension);
        }
    }

    /**
     * Allows the child classes to include specific data that could not be abstracted.
     */
    protected function addSpecificData(SimpleXMLElement $infData, ?SimpleXMLElement $extension = null)
    {
        $this->addInfData($infData);
        $this->addExtensionData($extension);
    }

    abstract protected function addInfData(SimpleXMLElement $infData);

    abstract protected function addExtensionData(?SimpleXMLElement $extension = null);

    abstract protected function setValue(SimpleXMLElement $infData);

    /**
     * Getter for the currently initialised child object.
     *
     * @return DomainObject|ContactObject|Nameserver|null
     */
    public function getObject()
    {
        return $this->object;
    }
}
