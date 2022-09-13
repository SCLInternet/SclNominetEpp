<?php

namespace SclNominetEpp;

use DOMDocument;
use SclRequestResponse\RequestInterface;
use SclRequestResponse\ResponseInterface;
use SimpleXMLElement;

/**
 * This class handles the essentials of all command requests
 */
class Request implements RequestInterface
{
    const XSI_NAMESPACE = 'http://www.w3.org/2001/XMLSchema-instance';

    /**
     * The PHP xml object which will be used to build the XML.
     */
    protected SimpleXMLElement $xml;

    /**
     * The XML output.
     */
    protected ?string $output = null;

    /**
     * The action this request will perform
     */
    protected string $action;

    /**
     * The type of response this request will return.
     */
    protected ?ResponseInterface $response = null;

    /**
     * Prepares the common XML wrapper for all requests.
     */
    public function __construct(string $action, ?ResponseInterface $response = null)
    {
        $this->action = $action;

        if ($response instanceof ResponseInterface) {
            $this->response = $response;
        } else {
            $this->response = new Response();
        }

        $this->xml = new SimpleXMLElement('<epp />');
    }

    /**
     * This method should be over to provide the content of the request.
     */
    protected function addContent(SimpleXMLElement $action)
    {
        // Nothing happens here
    }

    /**
     * FormatXml makes the XML readable.
     */
    protected function formatXml($xml)
    {
        $dom = new DOMDocument('1.0');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($xml);
        return $dom->saveXML();
    }

    /**
     * Returns the XML of the request.
     */
    public function getPacket(): ?string
    {
        if ($this->output !== null) {
            return $this->output;
        }

        $this->xml->addAttribute('xmlns', 'urn:ietf:params:xml:ns:epp-1.0');

        $this->xml->addAttribute(
            'xsi:schemaLocation',
            'urn:ietf:params:xml:ns:epp-1.0 epp-1.0.xsd',
            self::XSI_NAMESPACE
        );

        $command = $this->xml->addChild('command');

        $action  = $command->addChild($this->action);

        $this->addContent($action);
        // $command->addChild('clTRID', 'ABC-12345'); // @todo restore later

        $this->output = $this->xml->asXML();

        $this->output = str_replace(
            '<?xml version="1.0"?>',
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>',
            $this->output
        );

        $this->output = $this->formatXml($this->output);

        return $this->output;
    }

    /**
     * Return the response.
     */
    public function getResponse(): ?ResponseInterface
    {
        return $this->response;
    }
}
