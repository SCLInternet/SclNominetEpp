<?php
namespace SclNominetEpp\Request\Update\Field;

use SimpleXMLElement;

/**
 * Details the functions required for an UpdateField (fields like status)
 */
interface UpdateFieldInterface
{
    public function fieldXml(SimpleXMLElement $xml, string $namespace = null);
}
