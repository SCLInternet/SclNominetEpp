<?php

namespace SclNominetEpp;

use DateTime;

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

    /**
     * @param int $count
     */
    public function setCount(int $count): void
    {
        $this->count = $count;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getQueueDate()
    {
        return $this->queueDate;
    }

    /**
     * @param DateTime $queueDate
     */
    public function setQueueDate(DateTime $queueDate): void
    {
        $this->queueDate = $queueDate;
    }

    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
}
