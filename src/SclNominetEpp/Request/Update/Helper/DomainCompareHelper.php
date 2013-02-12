<?php
namespace SclNominetEpp\Request\Update\Helper;

/**
 * DocBlock: Description of DomainCompareHelper
 * 
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class DomainCompareHelper
{   
    public function __construct() {
    }
    
    public static function compare($a, $b)
    {
        if($a === $b)
        {
            return 0;
        }
            return 1;
    }
}
        