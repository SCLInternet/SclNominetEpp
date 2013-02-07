<?php

namespace SclNominetEpp;

use SimpleXMLElement;
use SclRequestResponse\Exception\InvalidResponsePacketException;
use SclRequestResponse\ResponseInterface;

class Response implements ResponseInterface
{
    /**
     * The response code.
     *
     * @var integer
     */
    protected $code;

    /**
     * The response message.
     *
     * @var string
     */
    protected $message;

    /**
     * Any extra response data.
     *
     * @var SimpleXMLElement
     */
    protected $data;

    /**
     * If $data is provided then it is passed to an init() call.
     *
     * @param string|null $data
     */
    public function __construct($data = null)
    {
        if (null !== $data) {
            $this->init($data);
        }
    }

    protected function processData($xml)
    {
        // Nothing to see here
    }

    /**
     * Read the data from an array into this object.
     *
     * @param string $data
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function init($xml)
    {
        echo $xml;
        $data = new SimpleXMLElement($xml);

        if (!isset($data->response)) {
            throw new InvalidResponsePacketException('XML is not a response packet.');
        }

        // TODO verify all these element exist

        $this->code = (int)$data->response->result->attributes()->code;
        $this->message = $data->response->result->msg;

        $this->data = array();

        $this->processData($data);

        // TODO save transactions

        return $this;
    }

    public function success()
    {
        return 1000 === $this->code;
    }

    public function code()
    {
        return $this->code;
    }

    public function message()
    {
        return $this->message;
    }

    public function data()
    {
        return $this->data;
    }
}
