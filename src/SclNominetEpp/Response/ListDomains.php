<?php

namespace SclNominetEpp\Response;

/**
 * This class interprets XML for a Nominet EPP list command response.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class ListDomains extends Response
{
    //put your code here
    protected $domains = array();

    protected function processData($data)
    {
        if (!isset($data->response->resData)) {
            return;
        }
        $ns = $data->getNamespaces(true);

        $domains = $data->response->resData->children($ns['list'])->listData;

        $this->domains = array();

        foreach ($domains->domainName as $domain) {
            $this->domains[] = (string)$domain;
        }
    }

    public function getDomains()
    {
        return $this->domains;
    }
}
