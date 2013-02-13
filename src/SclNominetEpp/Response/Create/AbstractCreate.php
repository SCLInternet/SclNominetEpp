<?php

namespace SclNominetEpp\Response\Create;

use DateTime;
use SclNominetEpp\Response;
use SclNominetEpp\Nameserver;

/**
 * This class interprets XML for a Nominet EPP <create> command response.
 * @todo finishing abstraction of create!
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
abstract class AbstractCreate extends Response
{
    protected $object;

    public function __construct($type, $valueName)
    {
        $this->type = $type;
        $this->valueName = $valueName;
    }
    
    public function processData($xml)
    {
        if (!isset($xml->response->resData)) {
            return;
        }
        $ns = $xml->getNamespaces(true);
        $this->object = new Nameserver();

        $response  = $xml->response;

        $creData   = $response->resData->children($ns["{$this->type}"])->creData;
        $this->object->setHostName($creData->name);
        $this->object->setCreated(new DateTime($creData->crDate));
    }

    public function getHost()
    {
        return $this->object;
    }
}
