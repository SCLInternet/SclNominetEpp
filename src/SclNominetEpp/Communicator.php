<?php
/**
 * Contains the Communicator class definition.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */

namespace SclNominetEpp;

use BasicSocket\SocketInterface;
use SclRequestResponse\Communicator\PersistentCommunicator;
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
     * Connection settings for Nominets server.
     *
     * @var array
     */
    public static $config = array(
        'live' => array(
            'secure' => array(
                'host' => 'epp.nominet.org.uk',
                'port' => '700',
            ),
            'insecure' => array(
                'host' => 'epp.nominet.org.uk',
                'port' => '8700',
            ),
        ),
        'test' => array(
            'secure' => array(
                'host' => 'testbed-epp.nominet.org.uk',
                'port' => '700',
            ),
            'insecure' => array(
                'host' => 'testbed-epp.nominet.org.uk',
                'port' => '8700',
            ),
        ),
    );

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
     * Connect to the server.
     *
     * @param boolean $live
     * @param boolean $secure
     *
     * @return void
     */
    public function connect($live = false, $secure = true)
    {
        $liveIndex = $live ? 'live' : 'test';
        $secureIndex = $secure ? 'secure' : 'insecure';

        $config = self::$config[$liveIndex][$secureIndex];

        parent::connect($config['host'], $config['port'], $secure);

        // TODO Parse and verify the greeting.
        $this->read();
    }
}
