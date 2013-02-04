<?php
/**
 * Contains the LoginRequire exception class definition.
 *
 * @author Tom Oram
 */

namespace SclNominetEpp\Exception;

/**
 * Exception to be thrown when the system is required to be logged in to
 * Nominet but currently isn't.
 *
 * @author Tom Oram
 */
class LoginRequiredException extends \Exception implements
    ExceptionInterface
{
}
