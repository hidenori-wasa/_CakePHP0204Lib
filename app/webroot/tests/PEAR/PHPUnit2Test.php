<?php

//use \BreakpointDebugging as B;

class PHPUnit2Test extends \BreakpointDebugging_PHPUnit_FrameworkTestCase
{
    //private $_testObject;
//    function setUp()
//    {
//        parent::setUp();
//
//        $this->_testObject = new \tests_PEAR_AClass();
//    }
//
//    function tearDown()
//    {
//        $this->_testObject = null;
//
//        parent::tearDown();
//    }

    /**
     * @covers \Example<extended>
     */
    public function testStoring_C()
    {
        // Asserts the value and the reference.
        parent::assertTrue(array (&\PHPUnit1Test::$initialReferenceOfGlobal) === array (&$_FILES));
        parent::assertTrue(\PHPUnit1Test::$initialValueOfGlobal === $_FILES);
        //parent::assertTrue(\PHPUnit1Test::$initialValueOfAutoProperty === \PHPUnit1Test::$testObject->autoProperty);
        parent::assertTrue(\PHPUnit1Test::$initialValueOfAutoProperty === \tests_PEAR_AClass::$objectProperty->autoProperty);
        parent::assertTrue(\PHPUnit1Test::$initialValueOfStaticProperty === \tests_PEAR_AClass::$staticProperty);
        //parent::assertTrue(B::clearRecursiveArrayElement(\tests_PEAR_AClass::$recursiveStaticProperty) === B::clearRecursiveArrayElement(\PHPUnit1Test::$initialValueOfRecursiveStaticProperty));
        // Changes the value and the reference.
        $_FILES = &$referenceChange3;
        $_FILES = 'The change value of global variable. 3';
        //\PHPUnit1Test::$testObject->autoProperty = 'The change value of auto property. 3';
        \tests_PEAR_AClass::$objectProperty->autoProperty = 'The change value of auto property. 3';
        \tests_PEAR_AClass::$staticProperty = 'The change value of static property. 3';
        //\tests_PEAR_AClass::$recursiveStaticProperty = 'The change value of recursive static property. 3';
    }

    /**
     * @covers \Example<extended>
     */
    public function testStoring_D()
    {
        // Asserts the value and the reference.
        parent::assertTrue(array (&\PHPUnit1Test::$initialReferenceOfGlobal) === array (&$_FILES));
        parent::assertTrue(\PHPUnit1Test::$initialValueOfGlobal === $_FILES);
        //parent::assertTrue(\PHPUnit1Test::$initialValueOfAutoProperty === \PHPUnit1Test::$testObject->autoProperty);
        parent::assertTrue(\PHPUnit1Test::$initialValueOfAutoProperty === \tests_PEAR_AClass::$objectProperty->autoProperty);
        parent::assertTrue(\PHPUnit1Test::$initialValueOfStaticProperty === \tests_PEAR_AClass::$staticProperty);
        //parent::assertTrue(B::clearRecursiveArrayElement(\tests_PEAR_AClass::$recursiveStaticProperty) === B::clearRecursiveArrayElement(\PHPUnit1Test::$initialValueOfRecursiveStaticProperty));
    }

}
