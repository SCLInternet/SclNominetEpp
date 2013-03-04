<?php

namespace SclNominetEpp\Request\Update\Release;

use SclNominetEpp\Response\Update\Release\Domain as ReleaseDomainResponse;

/**
 * This class build the XML for a Nominet EPP r:release command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Domain extends AbstractRelease
{
    const TYPE = 'domain'; //For possible Abstracting later
    const UPDATE_NAMESPACE = 'urn:ietf:params:xml:ns:release-1.0';
    const VALUE_NAME = 'domainName';

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(
            self::TYPE,
            self::UPDATE_NAMESPACE,
            self::VALUE_NAME,
            new ReleaseDomainResponse()
        );
    }
}
