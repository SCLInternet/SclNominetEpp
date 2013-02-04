<?php

namespace SclNominetEpp\Request;

use SclNominetEpp\Response\HostInfo as HostInfoResponse;

/**
 * This class build the XML for a Nominet EPP host:info command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class HostInfo extends AbstractInfo
{
    const TYPE = 'host';
    const INFO_NAMESPACE = "urn:ietf:params:xml:ns:host-1.0";
    const VALUE_NAME = "name";

    public function __construct()
    {
        parent::__construct(
            self::TYPE,
            self::INFO_NAMESPACE,
            self::VALUE_NAME,
            new HostInfoResponse()
        );
    }
}
