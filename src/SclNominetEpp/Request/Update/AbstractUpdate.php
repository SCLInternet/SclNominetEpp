<?php

namespace SclNominetEpp\Request\Update;

use SclNominetEpp\Request;
use SimpleXMLElement;
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

    protected $value;

    /**
     *
     * @param type $type
     * @param type $response
     * @param type $updateNamespace
     * @param type $valueName
     */
    public function __construct($type, $response, $updateNamespace, $valueName)
    {
        parent::__construct('update', $response);

        $this->type            = $type;
        $this->updateNamespace = $updateNamespace;
        $this->valueName       = $valueName;
    }

    public function lookup($value)
    {
        $this->value = $value;

        return $value;
    }

        /**
     * The <b>add()</b> function assigns a Field object as an element of the add array
     * for including specific fields in the update request "{$this->type}:add" tag.
     * ($this->type = 'domain' || 'contact' || 'contactID' || 'host'; (pseudo-code))
     *
     * @param \SclNominetEpp\Request\Update\Field\UpdateFieldInterface $field
     */
    protected function add(UpdateFieldInterface $field)
    {
        $this->add[] = $field;
    }

    /**
     * The <b>remove()</b> function assigns a Field object as an element of the remove array
     * for including specific fields in the update request "{$this->type}:remove" tag.
     * ($this->type = 'domain' || 'contact' || 'contactID' || 'host'; (pseudo-code))
     *
     * @param \SclNominetEpp\Request\Update\Field\UpdateFieldInterface $field
     */
    protected function remove(UpdateFieldInterface $field)
    {
        $this->remove[] = $field;
    }
}
