<?php

namespace SclNominetEpp\Request;

use DOMDocument;
use RequestResponse\RequestInterface;
use RequestResponse\ResponseInterface;
use SimpleXMLElement;
use SclNominetEpp\Response\Response;

class Request implements RequestInterface
{
    const XSI_NAMESPACE = 'http://www.w3.org/2001/XMLSchema-instance';

    /**
     * The PHP XMLWriter object which will be used to build the XML.
     *
     * @var XMLWriter
     */
    protected $xml;

    /**
     * The XML output.
     *
     * @var string
     */
    protected $output = null;

    /**
     * The action this request will perform
     *
     * @var string
     */
    protected $action;

    /**
     * The type of response this request will return.
     *
     * @var ResponseInterface
     */
    protected $response;

    /**
     * Prepares the common XML wrapper for all requests.
     *
     * @param string $action
     * @param ResponseInterface $response
     */
    public function __construct($action, $response = null)
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

    private function formatXml($xml)
    {
        $dom = new DOMDocument('1.0');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($xml);
        return $dom->saveXML();
    }

    /**
     * Returns the XML of the request.
     *
     * @return string
     */
    public function getPacket()
    {
        if (null !== $this->output) {
            return $this->output;
        }

        $this->xml->addAttribute('xmlns', 'urn:ietf:params:xml:ns:epp-1.0');

        $this->xml->addAttribute(
            'xsi:schemaLocation',
            'urn:ietf:params:xml:ns:epp-1.0 epp-1.0.xsd',
            self::XSI_NAMESPACE
        );

        $command = $this->xml->addChild('command');


        // TODO Does this need to be split for namespaces?
        $action = $command->addChild($this->action);

        $this->addContent($action);

        $this->output = $this->xml->asXML();

        $this->output = str_replace(
            '<?xml version="1.0"?>',
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>',
            $this->output
        );

        $this->output = $this->formatXml($this->output);

        //echo $this->output;
        
        return $this->output;
    }

    /**
     * Return the response.
     *
     * @return ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
