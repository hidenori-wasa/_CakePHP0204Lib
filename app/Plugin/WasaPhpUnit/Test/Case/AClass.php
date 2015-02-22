<?php

class AClass
{
    static $staticProperty = 'Initial value of static property.';
    public $autoProperty = 'Initial value of auto property.';
    static $recursiveStaticProperty = array ();

}

\AClass::$recursiveStaticProperty[] = &\AClass::$recursiveStaticProperty[0][0];
\AClass::$recursiveStaticProperty[] = 'Recursive static property element.';
