<?php

namespace SclNominetEpp\Response;

use SclNominetEpp\Response;
use SclNominetEpp\Greeting as GreetingObject;

/**
 * This class interprets XML for a Nominet EPP list command response.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Greeting extends Response
{
    protected $greetingObject;

    /**
     * {@inheritDoc}
     *
     * @param SimpleXMLElement $xml
     * @return void
     */
    protected function processData(SimpleXMLElement $xml)
    {
        if (!$this->success()) {
            return;
        }
        if (!$this->xmlValid($xml)) {
            return;
        }

        $this->greetingObject = new GreetingObject();
        $ns = $xml->getNamespaces(true);
        $this->greetingObject->setServerId($xml->svID);
        $this->greetingObject->setServerDate(new DateTime($xml->svDate));
        $serviceMenu = $xml->svcMenu;
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

        $dataCollectionPolicy = $xml->dcp;

        $access    = $dataCollectionPolicy->access;

        $statement = $dataCollectionPolicy->statement;

        $purposes   = $statement->children()->purpose;
        foreach ($purposes as $purpose) {
            $this->greetingObject->purposes[] = $purpose->getName();
        }

        $recipients  = $statement->children()->recipient;
        foreach ($recipients as $recipient) {
            $this->greetingObject->recipients[] = $recipient->getName();
        }

        $retention = $statement->retention;


    }

    protected function populate(SimpleXMLElement $xmlChildren, $childrenString){
        foreach ($xmlChildren as $xmlChild) {
            $this->greetingObject->$childrenString[] = $xmlChild->getName();
        }
    }

    /**
     *
     * @param \SimpleXMLElement $xml
     * @return boolean
     */
    public function xmlValid(SimpleXMLElement $xml)
    {
        return isset($xml);
    }
}
