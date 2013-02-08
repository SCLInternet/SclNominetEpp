<?php
namespace SclNominetEpp\Request\Update;


/**
 * Details the functions required for an UpdateField (fields like status)
 * 
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
interface UpdateFieldInterface
{
    public function addFieldXml(\SimpleXMLElement $xml, $namespace);
    
    public function remFieldXml();
}
