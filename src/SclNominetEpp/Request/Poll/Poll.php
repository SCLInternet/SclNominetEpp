<?php
/**
 * Contains the nominet Renew request class definition.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */

namespace SclNominetEpp\Request;

use SclNominetEpp\Response\Poll as PollResponse;
use SclNominetEpp\Request;

/**
 * This class build the XML for a Nominet EPP fork command.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class Poll extends Request
{
    const OP_ACKNOWLEDGE = 'ack';
    const OP_RETRIEVE    = 'req';

    private $op;
    /**
     * Tells the parent class what the action of this request is.
     */
    public function __construct($op)
    {
        parent::__construct('poll', new PollResponse);
        try {
            $this->setOp($op);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * (non-PHPdoc)
     * @see SclNominetEpp\Request.AbstractRequest::addContent()
     */
    protected function addContent(SimpleXMLElement $xml)
    {
       $this->xml->poll->addAttribute('op', $this->getOp());
    }

    public function getOp()
    {
        return $this->op;
    }

    public function setOp($op)
    {
        if (!($op == self::OP_ACKNOWLEDGE || $op == self::OP_RETRIEVE)) {
            throw new Exception("\"op\" is not legal, MUST be \"ack\" or \"req\".");
        }
        $this->op = $op;
    }
}
