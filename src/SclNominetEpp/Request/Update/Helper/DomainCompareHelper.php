<?php

namespace SclNominetEpp\Request\Update\Helper;

class DomainCompareHelper
{
    public static function compare(object $a, object $b): bool
    {
        return ($a == $b);
    }
}
