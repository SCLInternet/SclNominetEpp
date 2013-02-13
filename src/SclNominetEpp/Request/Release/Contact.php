<?php

namespace SclNominetEpp\Request\Release;

use SclNominetEpp\Response\Release\Contact as ReleaseContactResponse;

/**
 * This class build the XML for a Nominet EPP r:release command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Contact extends AbstractRelease
{
    const TYPE = 'contact'; //For possible Abstracting later
    const UPDATE_NAMESPACE = 'urn:ietf:params:xml:ns:release-1.0';
    const VALUE_NAME = 'registrant';

    protected $registrant = '';
    protected $value;

    public function __construct()
    {
        parent::__construct(
            self::TYPE,
            new ReleaseContactResponse(),
            self::UPDATE_NAMESPACE,
            self::VALUE_NAME
        );
    }
}
