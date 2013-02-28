<?php

namespace SclNominetEpp;

/**
 * This class represents the data of a poll response in an object.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Poll
{

    /**
     * Number of messages left unacknowledged in the queue.
     *
     * @var int
     */
    protected $count;

    /**
     * Poll Identifier
     *
     * @var string
     */
    protected $id;

    /**
     * Date of the message in the Queue.
     *
     * @var DateTime
     */
    protected $queueDate;

    /**
     * Poll Message.
     *
     * @var string
     */
    protected $message;


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
