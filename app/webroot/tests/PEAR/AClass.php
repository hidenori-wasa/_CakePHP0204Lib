<?php

class tests_PEAR_AClass
{
    static $staticProperty = 'Initial value of static property.';
    public $autoProperty = 'Initial value of auto property.';
    public $objectProperty;

    //static $recursiveStaticProperty = array ();
}

//\tests_PEAR_AClass::$recursiveStaticProperty[] = &\tests_PEAR_AClass::$recursiveStaticProperty[0][0];
//\tests_PEAR_AClass::$recursiveStaticProperty[] = 'Recursive static property element.';
