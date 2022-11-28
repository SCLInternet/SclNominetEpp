<?php

namespace SclNominetEpp\Response;

use DateTime;
use SclNominetEpp\Response;
use SclRequestResponse\ResponseInterface;
use SimpleXMLElement;
use SclNominetEpp\Greeting as GreetingObject;

/**
 * This class interprets XML for a Nominet EPP list command response.
 */
class Greeting extends Response
{
    protected $greetingObject;

    /**
     * @throws \Exception
     */
    public function init($data)
    {
        $data = new SimpleXMLElement($data);

        // TODO verify all these element exist

        $this->processData($data);

        // TODO save transactions
        return $this;
    }

    protected function processData(SimpleXMLElement $xml)
    {
        if (!$this->xmlValid($xml)) {
            return;
        }
        $this->greetingObject = new GreetingObject();
        $ns = $xml->getNamespaces(true);
        $this->greetingObject->setServerId($xml->greeting->svID);
        $this->greetingObject->setServerDate(new DateTime($xml->greeting->svDate));
        $serviceMenu = $xml->greeting->svcMenu;
        $this->greetingObject->setVersion($serviceMenu->version);
        $this->greetingObject->setLanguage($serviceMenu->lang);
        $objectURIs = $serviceMenu->children()->objURI;

        foreach ($objectURIs as $objectURI) {
            $this->greetingObject->addObjectURI((string)$objectURI);
        }

        $extensionURIs = $serviceMenu->svcExtension->children()->extURI;

        foreach ($extensionURIs as $extensionURI) {
            $this->greetingObject->addExtensionURI((string)$extensionURI);
        }

        $dataCollectionPolicy = $xml->greeting->dcp;
        $accesses = $dataCollectionPolicy->children()->access->children();
        foreach ($accesses as $access) {
            $this->greetingObject->setAccess($access->getName());
        }

        $statement = $dataCollectionPolicy->statement;

        $purposes   = $statement->children('purpose');
        foreach ($purposes as $purpose) {
            $this->greetingObject->addPurpose($purpose->getName());
        }

        $recipients  = $statement->children('recipient');
        foreach ($recipients as $recipient) {
            $this->greetingObject->addRecipient($recipient->getName());
        }

        $this->greetingObject->setRetention($statement->retention->getName());
    }
}
