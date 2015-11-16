<?php

include_once './BreakpointDebugging_Inclusion.php';

use \BreakpointDebugging as B;

/**
 * Checks recursive data error.
 *
 * @param mixed $objOrArray An object or an array.
 *
 * @return void
 */
function checkRecursiveDataError($objOrArray)
{
    ob_start();
    var_dump($objOrArray);
    $varDumpResult = ob_get_clean();
    $varDumpResult = strip_tags($varDumpResult);
    $lines = explode("\n", $varDumpResult);
    foreach ($lines as $line) {
        $result = preg_match('`^ [[:blank:]]* &`xX', $line);
        B::assert($result !== false);
        if ($result === 1) {
            throw new \BreakpointDebugging_ErrorException('Recursive data must not be used because of error cause.');
        }
    }
    return;
}

class Class1
{
    private $element1;

    function setElement1($value)
    {
        $this->element1 = $value;
    }

    // リソース (Is a clone error generated?)
    //
    // クロージャ (Is a clone error generated?)
    //
    // 内部エクステンション (Is a clone error generated?)
//
}

class Class2
{
    public $element2;

}

$object1 = new \Class1();
$object2 = new \Class2();
$object3 = new \Class1();
$object1->setElement1($object2);
$object2->element2 = $object3;
$array1 = array (1, array (2, $object1));
// $object3->setElement1($array1);
checkRecursiveDataError($array1);
exit('Success!');



$objectReflection = new ReflectionObject($object2);
exit;
