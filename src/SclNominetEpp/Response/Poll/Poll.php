<?php

namespace SclNominetEpp\Response\Poll;

use SclNominetEpp\Response;

/**
 * This class interprets XML for a Nominet EPP poll command response.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Poll extends Response{

    protected $count;

    protected $id;


    public function __construct()
    {
        ;
    }

    public function processData(\SimpleXMLElement $xml)
    {
        if (!$this->success()) {
            //has been acknowledged

        } else if (1301 === $this->code()) {
            //requires acknowledged
            $messageQ = $xml->response->msgQ;
            $this->count = (int) $messageQ->attributes()->count;
            $this->id    = (string) $messageQ->attributes()->id;


        } else {
            return;
        }

    }
}
