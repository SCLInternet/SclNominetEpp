<?php

namespace SclNominetEpp;

use SclNominetEpp\Exception\RuntimeException;
use SclRequestResponse\Exception\InvalidResponsePacketException;
use SclRequestResponse\ResponseInterface;
use SimpleXMLElement;

/**
 * This class handles the essentials of all command responses
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

    //RESULT ERROR CODES (2YZZ)
    //X0ZZ
    const ERROR_UNKNOWN_COMMAND                                  = 2000;
    const ERROR_COMMAND_SYNTAX                                   = 2001;
    const ERROR_COMMAND_USE                                      = 2002;
    const ERROR_REQUIRED_PARAMETER_MISSING                       = 2003;
    const ERROR_PARAMETER_VALUE_RANGE                            = 2004;
    const ERROR_PARAMETER_VALUE_SYNTAX                           = 2005;
    //X1ZZ
    const ERROR_UNIMPLEMENTED_PROTOCOL_VERSION                   = 2100;
    const ERROR_UNIMPLEMENTED_COMMAND                            = 2101;
    const ERROR_UNIMPLEMENTED_OPTION                             = 2102;
    const ERROR_UNIMPLEMENTED_EXTENSION                          = 2103;
    const ERROR_BILLING_FAILURE                                  = 2104;
    const ERROR_RENEWAL_INELIGIBLE                               = 2105;
    const ERROR_TRANSFER_INELIGIBLE                              = 2106;
    //X2ZZ
    const ERROR_AUTHENTICATION                                   = 2200;
    const ERROR_AUTHORIZATION                                    = 2201;
    const ERROR_INVALID_AUTHORIZATION_INFORMATION                = 2202;
    //X3ZZ
    const ERROR_PENDING_TRANSFER                                 = 2300;
    const ERROR_NOT_PENDING_TRANSFER                             = 2301;
    const ERROR_OBJECT_EXISTS                                    = 2302;
    const ERROR_OBJECT_DOES_NOT_EXIST                            = 2303;
    const ERROR_OBJECT_STATUS_PROHIBITS_OPERATION                = 2304;
    const ERROR_PARAMETER_VALUE_POLICY                           = 2305;
    const ERROR_UNIMPLEMENTED_OBJECT_SERVICE                     = 2307;
    const ERROR_DATA_MANAGEMENT_POLICY_VIOLATION                 = 2308;
    //X4ZZ
    const ERROR_COMMAND_FAILED                                   = 2400;
    //X5ZZ
    const ERROR_COMMAND_FAILED_SERVER_CLOSING_CONNECTION         = 2500;
    const ERROR_AUTHENTICATION_SERVER_CLOSING_CONNECTION         = 2501;
    const ERROR_SESSION_LIMIT_EXCEEDED_SERVER_CLOSING_CONNECTION = 2502;

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
     * @var SimpleXMLElement
     */
    protected $data;

    /**
     * Custom processing of the XML response.
     */
    protected function processData(SimpleXMLElement $xml)
    {
        if (!$this->success()) {
            return;
        }
        if (!$this->xmlValid($xml->response->resData)) {
            return;
        }
        return;
    }

    /**
     * Read the data from an array into this object.
     * @throws InvalidResponsePacketException
     * @throws \Exception
     */
    public function init(string $data): ResponseInterface
    {
        $data = new SimpleXMLElement($data);

        if (!isset($data->response)) {
            throw new InvalidResponsePacketException('XML is not a response packet.');
        }

        $this->code    = (int) $data->response->result->attributes()->code;
        $this->message = (string) $data->response->result->msg;

        $this->data = [];

        if (!$this->isErrorCode($this->code) && !$this->isSuccessCode($this->code)) {
            throw RuntimeException::unexpectedResultCode($this->code, $this->message);
        }

        $this->processData($data);

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
     */
    public function success(): bool
    {
        return $this->isSuccessCode($this->code);
    }

    /**
     * Get the response code
     */
    public function code(): int
    {
        return $this->code;
    }

    /**
     * Get the response message
     */
    public function message(): string
    {
        return $this->message;
    }

    /**
     * Get any extra response data
     */
    public function data(): SimpleXMLElement
    {
        return $this->data;
    }

    /**
     * Check if the given code is an error code.
     *
     * @param  int $code
     * @return bool
     */
    protected function isErrorCode($code)
    {
        return in_array($code, self::$errorCodes);
    }

    protected function isSuccessCode(int $code): bool
    {
        return in_array($code, self::$successCodes);
    }

    public function xmlValid(SimpleXMLElement $xml): bool
    {
        return $xml->valid();
    }
}
