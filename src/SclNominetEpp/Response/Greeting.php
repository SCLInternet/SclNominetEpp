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

    protected $objectURIs;
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
        $this->objectURIs = $serviceMenu->children()->objURI;

        foreach ($this->objectURIs as $objectURI) {
            $this->greetingObject->addObjectURI((string)$objectURI);
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
