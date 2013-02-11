<?php
namespace SclNominetEpp\Request\Update\Field;


/**
 * Details the functions required for an UpdateField (fields like status)
 * 
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
interface UpdateFieldInterface
{
    public function fieldXml(\SimpleXMLElement $xml, $namespace);
}
