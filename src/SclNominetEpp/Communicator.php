<?php
/**
 * Contains the Communicator class definition.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */

namespace SclNominetEpp;

use BasicSocket\SocketInterface;
use RequestResponse\Communicator\PersistentCommunicator;
use SclNominetEpp\Request\RequestInterface;
use SclNominetEpp\Response\ResponseInterface;
use SimpleXMLElement;

/**
 * Sets up communication with the Nominet EPP server and sends requests and
 * processes the responses.
 *
 * @author Tom Oram
 */
class Communicator extends PersistentCommunicator
{
    /**
     * Constructor
     *
     * @param SocketInterface $socket
     */
    public function __construct(SocketInterface $socket)
    {
        parent::__construct($socket, '!</epp>!');
    }

    /**
     * {@inheritDoc}
     */
    public function connect($host, $port, $secure = true)
    {
        parent::connect($host, $port, $secure);

        // TODO Parse and verify the greeting.
        $this->read();
    }
}
