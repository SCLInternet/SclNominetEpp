<?php

namespace SclNominetEpp\Response\Update;

use SclNominetEpp\Response;
use SimpleXMLElement;

/**
 * This class interprets XML for a Nominet EPP unrenew command response.
 */
class Unrenew extends Response
{
    public function __construct()
    {
        // @todo
    }

    public function processData(SimpleXMLElement $xml)
    {
        if (!$this->success()) {
            return;
        }
        // @todo
    }
}
