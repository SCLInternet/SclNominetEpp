<?php

namespace SclNominetEpp\Exception;

/**
 * RuntimeException
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class RuntimeException extends \RuntimeException implements ExceptionInterface
{
    public static function unexpectedResultCode($code, $message)
    {
        throw new self("Unexpected result code: $code, message: $message");
    }
}
