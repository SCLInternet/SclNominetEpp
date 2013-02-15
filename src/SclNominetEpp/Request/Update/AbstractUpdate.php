<?php

namespace SclNominetEpp\Request\Update;

use SclNominetEpp\Request;
use SclNominetEpp\Request\Update\Field\UpdateFieldInterface;

/**
 * This abstract class enables building the XML for a Nominet EPP update command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
abstract class AbstractUpdate extends Request
{
    
    protected $type;
    
    protected $updateNamespace;
    
    protected $valueName;
    
    public function __construct($type, $response, $updateNamespace, $valueName)
    {
        parent::__construct('update', $response);
        
        $this->type            = $type;
        $this->updateNamespace = $updateNamespace;
        $this->valueName       = $valueName;
    }
    
    abstract protected function add(UpdateFieldInterface $field);
    abstract protected function remove(UpdateFieldInterface $field);
}
