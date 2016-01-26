<?php

//class tests_PEAR_AClass
class AClass
{
    static $staticProperty = 'Initial value of static property.';
    static $objectProperty;

    function __construct()
    {
        //self::$objectProperty = new \tests_PEAR_AClass2();
        self::$objectProperty = new \AClass2();
    }

}
