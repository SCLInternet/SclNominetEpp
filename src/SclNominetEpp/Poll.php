<?php

namespace SclNominetEpp;

/**
 * This class represents the data of a poll response in an object.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Poll{

    protected $count;

    protected $id;

    protected $queueDate;

    protected $message;

    /**
     * Number of messages left unacknowledged in the queue.
     *
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Identifier
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Date of the message in the Queue.
     *
     * @return DateTime
     */
    public function getQueueDate()
    {
        return $this->queueDate;
    }

    /**
     * Message.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }


}
