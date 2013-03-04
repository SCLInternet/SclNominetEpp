<?php

namespace SclNominetEpp\Response;

use SclRequestResponse\ResponseInterface;
use SimpleXMLElement;
use DateTime;
use SclNominetEpp\Greeting as GreetingObject;

/**
 * This class interprets XML for a Nominet EPP list command response.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Greeting implements ResponseInterface
{
    protected $greetingObject;

    /**
     * Read the data from an array into this object.
     * Greeting doesn't use the "<response>" tag
     * so "init()" needs to be overwritten to avoid redundant validation
     *
     * @param string $xml
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function init($xml)
    {
        echo $xml;
        $data = new SimpleXMLElement($xml);

        // TODO verify all these element exist

        $this->processData($data);

        // TODO save transactions
        return $this;
    }

    /**
     * {@inheritDoc}
     *
     * @param SimpleXMLElement $xml
     * @return void
     */
    protected function processData(SimpleXMLElement $xml)
    {
        if (!$this->xmlValid($xml)) {
            return;
        }
        //var_dump($xml);

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

    /**
     *
     * @param SimpleXMLElement $xml
     * @return boolean
     */
    public function xmlValid(SimpleXMLElement $xml)
    {
        return isset($xml);
    }

    public function code()
    {
        return SclNominetEpp\Response::SUCCESS_STANDARD;
    }

    public function data()
    {
        return null;
    }

    public function message()
    {
        return '';
    }

    public function success()
    {
        return true;
    }
}
