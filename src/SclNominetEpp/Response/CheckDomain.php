<?php

namespace SclNominetEpp\Response;

/**
 * This class interprets XML for a Nominet EPP domain:check command response.
 *
 * @author tom
 */
class CheckDomain extends Response
{
    protected $domains;

    protected function processData($data)
    {
        if (!isset($data->response->resData)) {
            return;
        }

        $ns = $data->getNamespaces(true);

        $domains = $data->response->resData->children($ns['domain']);

        $this->domains = array();

        foreach ($domains->chkData->cd as $domain) {
            $this->domains[(string)$domain->name] = (boolean)(string)$domain->name->attributes()->avail;
        }
    }

    public function getDomains()
    {
        return $this->domains;
    }
}
