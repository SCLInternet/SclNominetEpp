<?php
/**
 * Contains the nominet Login request class definition.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */

namespace SclNominetEpp\Request;

use SclNominetEpp\Response\Greeting;
use SclNominetEpp\Request;

/**
 * This class build the XML for a Nominet EPP hello command.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class Hello extends Request
{
    public function __construct()
    {
        parent::__construct('hello', new Greeting());
    }
}
