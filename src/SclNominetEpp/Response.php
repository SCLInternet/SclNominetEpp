<?php

namespace SclNominetEpp;

use SimpleXMLElement;
use SclRequestResponse\Exception\InvalidResponsePacketException;
use SclRequestResponse\ResponseInterface;
use Exception;

/**
 * This class handles the essentials of all command responses
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class Response implements ResponseInterface
{
    /**
     * {@link http://tools.ietf.org/html/rfc4930#section-3 Result Codes}
     */
    //RESULT SUCCESS CODES  (1YZZ)
    const SUCCESS_STANDARD          = 1000;
    const SUCCESS_ACTION_PENDING    = 1001;
    const SUCCESS_NO_MESSAGES       = 1300;
    const SUCCESS_MESSAGE_RETRIEVED = 1301;
    const SUCCESS_ENDING_SESSION    = 1500;
    //RESULT ERROR CODES    (2YZZ)
        //X0ZZ
    const ERROR_UNKNOWN_COMMAND             = 2000;
    const ERROR_COMMAND_SYNTAX              = 2001;
    const ERROR_COMMAND_USE                 = 2002;
    const ERROR_REQUIRED_PARAMETER_MISSING  = 2003;
    const ERROR_PARAMETER_VALUE_RANGE       = 2004;
    const ERROR_PARAMETER_VALUE_SYNTAX      = 2005;
        //X1ZZ
    const ERROR_UNIMPLEMENTED_PROTOCOL_VERSION  = 2100;
    const ERROR_UNIMPLEMENTED_COMMAND           = 2101;
    const ERROR_UNIMPLEMENTED_OPTION            = 2102;
    const ERROR_UNIMPLEMENTED_EXTENSION         = 2103;
    const ERROR_BILLING_FAILURE                 = 2104;
    const ERROR_RENEWAL_INELIGIBLE              = 2105;
    const ERROR_TRANSFER_INELIGIBLE             = 2106;
        //X2ZZ
    const ERROR_AUTHENTICATION                      = 2200;
    const ERROR_AUTHORIZATION                       = 2201;
    const ERROR_INVALID_AUTHORIZATION_INFORMATION   = 2202;
        //X3ZZ
    const ERROR_PENDING_TRANSFER                    = 2300;
    const ERROR_NOT_PENDING_TRANSFER                = 2301;
    const ERROR_OBJECT_EXISTS                       = 2302;
    const ERROR_OBJECT_DOES_NOT_EXIST               = 2303;
    const ERROR_OBJECT_STATUS_PROHIBITS_OPERATION   = 2304;
    const ERROR_PARAMETER_VALUE_POLICY              = 2305;
    const ERROR_UNIMPLEMENTED_OBJECT_SERVICE        = 2307;
    const ERROR_DATA_MANAGEMENT_POLICY_VIOLATION    = 2308;
        //X4ZZ
    const ERROR_COMMAND_FAILED = 2400;
        //X5ZZ
    const ERROR_COMMAND_FAILED_SERVER_CLOSING_CONNECTION            = 2500;
    const ERROR_AUTHENTICATION_SERVER_CLOSING_CONNECTION            = 2501;
    const ERROR_SESSION_LIMIT_EXCEEDED_SERVER_CLOSING_CONNECTION    = 2502;

    protected static $successCodes = array(
        self::SUCCESS_STANDARD,
        self::SUCCESS_ACTION_PENDING,
        self::SUCCESS_NO_MESSAGES,
        self::SUCCESS_MESSAGE_RETRIEVED,
        self::SUCCESS_ENDING_SESSION
    );

    protected static $errorCodes = array(
        self::ERROR_UNKNOWN_COMMAND,
        self::ERROR_COMMAND_SYNTAX,
        self::ERROR_COMMAND_USE,
        self::ERROR_REQUIRED_PARAMETER_MISSING,
        self::ERROR_PARAMETER_VALUE_RANGE,
        self::ERROR_PARAMETER_VALUE_SYNTAX,
        self::ERROR_UNIMPLEMENTED_PROTOCOL_VERSION,
        self::ERROR_UNIMPLEMENTED_COMMAND,
        self::ERROR_UNIMPLEMENTED_OPTION,
        self::ERROR_UNIMPLEMENTED_EXTENSION,
        self::ERROR_BILLING_FAILURE,
        self::ERROR_RENEWAL_INELIGIBLE,
        self::ERROR_TRANSFER_INELIGIBLE,
        self::ERROR_AUTHENTICATION,
        self::ERROR_AUTHORIZATION,
        self::ERROR_INVALID_AUTHORIZATION_INFORMATION,
        self::ERROR_PENDING_TRANSFER,
        self::ERROR_NOT_PENDING_TRANSFER,
        self::ERROR_OBJECT_EXISTS,
        self::ERROR_OBJECT_DOES_NOT_EXIST,
        self::ERROR_OBJECT_STATUS_PROHIBITS_OPERATION,
        self::ERROR_PARAMETER_VALUE_POLICY,
        self::ERROR_UNIMPLEMENTED_OBJECT_SERVICE,
        self::ERROR_DATA_MANAGEMENT_POLICY_VIOLATION,
        self::ERROR_COMMAND_FAILED,
        self::ERROR_COMMAND_FAILED_SERVER_CLOSING_CONNECTION,
        self::ERROR_AUTHENTICATION_SERVER_CLOSING_CONNECTION,
        self::ERROR_SESSION_LIMIT_EXCEEDED_SERVER_CLOSING_CONNECTION
    );

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
     * @todo WHAT THE FRAK ARE YOU ON ABOUT TOM?
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

        if ((!in_array($this->code(), self::$errorCodes))&&(!in_array($this->code(), self::$successCodes))) {
            throw new Exception("Unexpected result-code: {$this->code()}");
        }

        if (!$this->success()) {
            return $this->message();
        }

        $this->processData($data);

        // TODO save transactions
        return $this;
    }

    /**
     * Get boolean of success of the command from the response.
     *
     * Success is dictated by the {@link http://tools.ietf.org/html/rfc4930#section-3 Result Codes}
     *
     * There are two values for the first digit of the reply code:
     *
     * 1yzz    Positive completion reply.
     * 2yzz    Negative completion reply.
     *
     * @return boolean
     */
    public function success()
    {
        $code = (string)$this->code;
        return "1" === $code[0];
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
