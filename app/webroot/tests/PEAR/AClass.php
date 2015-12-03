<?php

class tests_PEAR_AClass
{
    static $staticProperty = 'Initial value of static property.';
    static $objectProperty;

    function __construct()
    {
        self::$objectProperty = new \tests_PEAR_AClass2();
    }

}
