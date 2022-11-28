<?php

namespace SclNominetEpp;

use SclRequestResponse\AbstractRequestResponse as BaseAbstractRequestResponse;
use SclRequestResponse\RequestInterface;

abstract class AbstractRequestResponse extends BaseAbstractRequestResponse
{
    /**
     * @var RequestInterface
     */
    private $request;

    public function processRequest(RequestInterface $request)
    {
        $this->request = $request;
        return parent::processRequest($request);
    }

    public function getRequest(): RequestInterface
    {
        return $this->request;
    }
}
