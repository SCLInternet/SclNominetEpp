<?php

namespace SclNominetEpp\Response\Poll;

use SclNominetEpp\Response;
use SclNominetEpp\Poll as PollObject;
use SimpleXMLElement;
use Exception;

/**
 * This class interprets XML for a Nominet EPP poll command response.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Poll extends Response{

    protected $poll;

    public function __construct()
    {
        $this->poll = new PollObject();
    }

    /**
     *
     * @param \SimpleXMLElement $xml
     * @return type
     * @throws Exception
     */
    public function processData(SimpleXMLElement $xml)
    {
        $messageQueue = $xml->response->msgQ;
        $this->poll->count = (int) $messageQueue->attributes()->count;
        $this->poll->id    = (string) $messageQueue->attributes()->id;

        if (self::SUCCESS_MESSAGE_RETRIEVED === $this->code()) {
            $this->poll->queueDate = new DateTime((string)$messageQueue->qDate);
            $this->poll->message   = (string)$messageQueue->msg;
        }
    }
}
