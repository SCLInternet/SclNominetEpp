<?php

namespace SclNominetEpp\Response;

/**
 * This class interprets XML for a Nominet EPP host:check command response.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class CheckHost extends Response
{
    protected $hosts;
    
    protected function processData($data)
    {
        if (!isset($data->response->resData)) {
            return;
        }

        $ns = $data->getNamespaces(true);

        $hosts = $data->response->resData->children($ns['host']);

        $this->hosts = array();

        foreach ($hosts->chkData->cd as $host) {
            $this->hosts[(string)$host->name] = (boolean)(string)$host->name->attributes()->avail;
        }
    }
    
    public function getHosts()
    {
        return $this->hosts;
    }
}
