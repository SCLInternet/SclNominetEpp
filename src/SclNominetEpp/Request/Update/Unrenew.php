<?php
namespace SclNominetEpp\Request\Update;

use SclNominetEpp\Request;
use SclNominetEpp\Response\Update\Unrenew as UnrenewResponse;

class Unrenew extends Request
{
    const UNRENEW_NAMESPACE = 'http://www.nominet.org.uk/epp/xml/std-unrenew-1.0';

    protected $domainNames;

    public function __construct()
    {
        parent::__construct('update', new UnrenewResponse());
    }

    public function addContent(\SimpleXMLElement $action)
    {
        $unrenewNS  = self::UNRENEW_NAMESPACE;

        $unrenewXSI = $unrenewNS . ' ' . 'std-unrenew-1.0.xsd';

        $update = $action->addChild('u:unrenew', '', $unrenewNS);
        $update->addAttribute('xsi:schemaLocation', $unrenewXSI);
        if (!empty($this->domainNames)) {
            foreach ($this->domainNames as $domainName) {
                $update->addChild('domainName', $domainName, $unrenewNS);
            }
        }
    }
}
