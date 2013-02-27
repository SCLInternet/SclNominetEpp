<?php
/**
 * Contains the nominet Login request class definition.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */

namespace SclNominetEpp\Request;

use SimpleXMLElement;
use SclNominetEpp\Response\Greeting;
use SclNominetEpp\Request;

/**
 * This class build the XML for a Nominet EPP hello command.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class Hello extends Request
{
    /**
     * Hello doesn't use the "<command>" tag
     * so "getPacket()" needs to be overwritten to avoid redundant validation
     *
     * @return type
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

        // TODO Does this need to be split for namespaces?
        $action = $this->xml->addChild('hello');

        $this->addContent($action);

        $this->output = $this->xml->asXML();

        $this->output = str_replace(
            '<?xml version="1.0"?>',
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>',
            $this->output
        );

        $this->output = $this->formatXml($this->output);
        echo $this->output;
        return $this->output;
    }
}
