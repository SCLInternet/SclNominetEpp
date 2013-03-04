<?php

namespace SclNominetEpp\Response\Update\Fork;

use SclNominetEpp\Response;

/**
 * This class interprets XML for a Nominet EPP fork command response.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Fork extends Response
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
     * @var ForkObject
     */
    protected $fork;

    /**
     * {@inheritDoc}
     *
     * @param \SimpleXMLElement $xml
     * @return void
     */
    protected function processData(SimpleXMLElement $xml)
    {
        if (!$this->success()) {
            return;
        }
        if (!$this->xmlValid($xml->response->resData)) {
            return;
        }

        $ns = $xml->getNamespaces(true);

        $contactDetails = $xml->response->resData->children($ns['contact'])->creData;
        $this->contactId = $contactDetails->id;
        $this->createDate = $contactDetails->crDate;

    }

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
