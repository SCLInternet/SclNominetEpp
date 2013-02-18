<?php

namespace SclNominetEpp;

use SimpleXMLElement;
use SclRequestResponse\Exception\InvalidResponsePacketException;
use SclRequestResponse\ResponseInterface;

/**
 * This class handles the essentials of all command responses
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
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
     * Custom processing of the XML response.
     *
     * @param SimpleXMLElement $xml
     * @return void
     */
    protected function processData(SimpleXMLElement $xml)
    {
        // Nothing to see here
    }

    /**
     * Read the data from an array into this object.
     *
     * @param string $xml
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

        $this->code = (int) $data->response->result->attributes()->code;
        $this->message = $data->response->result->msg;

        $this->data = array();

        $this->processData($data);

        // TODO save transactions
        return $this;
    }

    /**
     * Get boolean of success of the command from the response.
     * 
     * @return boolean
     */
    public function success()
    {
        return 1000 === $this->code;
    }

    /**
     * Get the response code
     * 
     * @return int
     */
    public function code()
    {
        return $this->code;
    }

    /**
     * Get the response message
     * 
     * @return string
     */
    public function message()
    {
        return $this->message;
    }

    /**
     * Get any extra response data
     * 
     * @return SimpleXMLElement
     */
    public function data()
    {
        return $this->data;
    }
}
