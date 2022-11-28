<?php

namespace SclNominetEpp\Request\Poll;

use SclNominetEpp\Request;
use SclNominetEpp\Response\Poll as PollResponse;
use SimpleXMLElement;

/**
 * This class builds the XML for a Nominet EPP <poll> command.
 */
class Poll extends Request
{
    const OP_ACKNOWLEDGE = 'ack';
    const OP_RETRIEVE    = 'req';

    private string $op;

    /**
     * Tells the parent class what the action of this request is.
     */
    public function __construct(string $op)
    {
        parent::__construct('poll', new PollResponse());
        $this->setOp($op);
    }

    protected function addContent(SimpleXMLElement $action)
    {
        $this->xml->poll->addAttribute('op', $this->getOp());
    }

    public function getOp(): string
    {
        return $this->op;
    }

    public function setOp(string $op)
    {
        if (!($op == self::OP_ACKNOWLEDGE || $op == self::OP_RETRIEVE)) {
            throw new \InvalidArgumentException("The op \"$op\" is not legal, MUST be \"ack\" or \"req\".");
        }
        $this->op = $op;
    }
}
