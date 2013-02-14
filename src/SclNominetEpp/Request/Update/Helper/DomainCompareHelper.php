<?php
namespace SclNominetEpp\Request\Update\Helper;

/**
 * DocBlock: Description of DomainCompareHelper
 * 
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class DomainCompareHelper
{
    /**
     * Constructor
     */
    public function __construct()
    {
    }
    
    /**
     * Used to compare objects.
     * 
     * @param object $a
     * @param object $b
     * @return int
     */
    public static function compare($a, $b)
    {
        if ($a === $b) {
            return 0;
        } return 1;
    }
}
