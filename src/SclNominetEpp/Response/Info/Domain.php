<?php

namespace SclNominetEpp\Response\Info;

use DateTime;
use SimpleXMLElement;
use SclNominetEpp\Domain as DomainObject;
use SclNominetEpp\Nameserver;

/**
 * This class interprets XML for a Nominet EPP domain:info command response.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Domain extends AbstractInfo
{
    const TYPE = 'domain';
    const VALUE_NAME = 'name';

    /** @var ?DomainObject */
    protected $object;

    public function __construct()
    {
        parent::__construct(
            self::TYPE,
            new DomainObject(),
            self::VALUE_NAME
        );
    }

    public function getDomain(): ?DomainObject
    {
        return $this->object;
    }

    protected function addInfData(SimpleXMLElement $infData)
    {

        $nschildren = $infData->ns->hostObj;
        foreach ($nschildren as $nschild) {
            $nameserver = new Nameserver();
            $nameserver->setHostName((string)$nschild);
            $this->object->addNameserver($nameserver);
        }

        $this->object->setRegistrant($infData->registrant);

        $this->object->setCreatorID($infData->crID);
        $this->object->setExpired(new DateTime((string) $infData->exDate));
        $this->object->setUpID($infData->upID);
    }

    protected function addExtensionData(SimpleXMLElement $extension = null)
    {
                //EXTENSION DATA
        $this->object->setRegStatus($extension->{'reg-status'});
        $this->object->setFirstBill($extension->{'first-bill'});
        $this->object->setRecurBill($extension->{'recur-bill'});
        $this->object->setAutoBill($extension->{'auto-bill'});
        $this->object->setNextBill($extension->{'next-bill'});
    }

    protected function setValue(SimpleXMLElement $name)
    {
        $this->object->setName((string)$name);
    }
}
