<?php

include_once './BreakpointDebugging_Inclusion.php';

use \BreakpointDebugging as B;

$base = array('berries' => array('blackberry', 'raspberry'), 'others' => 'banana');
$replacements = array('berries' => array('blueberry'), 'others' => array('litchis'));
$replacements2 = array('berries' => array('blueberry2'), 'others' => 'litchis');
// 同じキーの値が順番に上書きされる
// 同じキーの値が配列同士の場合、再帰的に処理される
// 別のキーの要素は結合される
$basket = array_replace_recursive($base, $replacements, $replacements2);
var_dump($basket);
exit;

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
