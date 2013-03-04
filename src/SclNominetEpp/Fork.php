<?php

namespace SclNominetEpp;

/**
 * This class is the fork object for the fork command response data
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Fork
{
    /**
     * New contact identifier.
     *
     * @var string
     */
    protected $contactId;

    /**
     * The Date of contact creation.
     *
     * @var DateTime
     */
    protected $createDate;


    /**
     *
     * @return string
     */
    public function getContactId()
    {
        return $this->contactId;
    }

    /**
     *
     * @param string $contactId
     */
    public function setContactId($contactId)
    {
        $this->contactId = $contactId;
    }

    /**
     *
     * @return DateTime
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     *
     * @param DateTime $createDate
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;
    }
}
