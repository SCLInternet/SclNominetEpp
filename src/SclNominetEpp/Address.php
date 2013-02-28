<?php

namespace SclNominetEpp;

/**
 * DocBlock: Description of Address
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Address extends \SclContact\Address
{


    public function setLines(array $lines)
    {
        if (count($lines) === 3) {
            $this->setLine1($lines[0] . ', ' . $lines[1]);
            $this->setLine2($lines[2]);
        }

        $this->setLine1($lines[0]);

        if (isset($lines[1])) {
            $this->setLine2($lines[1]);
        }
    }

    /**
     * @todo swap all references of state/province to County
     *
     */

    /**
     * @todo swap all references of countryCode to country
     */
}
