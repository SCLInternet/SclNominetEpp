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

    protected $queueDate;

    protected $message;

    public function __construct()
    {
        ;
    }

    public function processData(\SimpleXMLElement $xml)
    {
        if ($this->success()) {
            $messageQueue = $xml->response->msgQ;
            $this->count = (int) $messageQueue->attributes()->count;
            $this->id    = (string) $messageQueue->attributes()->id;

            if (self::SUCCESS_MESSAGE_RETRIEVED === $this->code()) {
                $this->queueDate = new DateTime((string)$messageQueue->qDate);
                $this->message   = (string)$messageQueue->msg;
            }
        }
    }

    public function getCount()
    {
        return $this->count;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getQueueDate()
    {
        return $this->queueDate;
    }

    public function getMessage()
    {
        return $this->message;
    }


}
