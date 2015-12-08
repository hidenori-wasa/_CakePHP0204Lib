<?php

//use \BreakpointDebugging as B;

class PHPUnit1Test extends \BreakpointDebugging_PHPUnit_FrameworkTestCase
{
    static $initialValueOfGlobal;
    static $initialReferenceOfGlobal;
    static $initialValueOfAutoProperty;
    static $initialValueOfStaticProperty;

    //static $testObject;

    static function setUpBeforeClass()
    {
        new \PHP_Timer();
        new \tests_PEAR_AClass();
        new \PHPUnit_Framework_Constraint_IsTrue();
        parent::setUpBeforeClass();

        //self::$testObject = new \tests_PEAR_AClass();
        //new \tests_PEAR_AClass();
    }

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
    public function testStoring_A()
    {
        new \tests_PEAR_AClass;

        // Stores the initial value and the initial reference.
        self::$initialReferenceOfGlobal = &$_FILES;
        self::$initialValueOfGlobal = $_FILES;
        //self::$initialValueOfAutoProperty = self::$testObject->autoProperty;
        self::$initialValueOfAutoProperty = \tests_PEAR_AClass::$objectProperty->autoProperty;
        self::$initialValueOfStaticProperty = \tests_PEAR_AClass::$staticProperty;
        //self::$initialValueOfRecursiveStaticProperty = \tests_PEAR_AClass::$recursiveStaticProperty;
        // Changes the value and the reference.
        $_FILES = &$referenceChange;
        $_FILES = 'The change value of global variable.';
        //self::$testObject->autoProperty = 'The change value of auto property.';
        \tests_PEAR_AClass::$objectProperty->autoProperty = 'The change value of auto property.';
        \tests_PEAR_AClass::$staticProperty = 'The change value of static property.';
        //\tests_PEAR_AClass::$recursiveStaticProperty = 'The change value of recursive static property.';
    }

    /**
     * @covers \Example<extended>
     */
    public function testStoring_B()
    {
        // Asserts the value and the reference.
        parent::assertTrue(array (&self::$initialReferenceOfGlobal) === array (&$_FILES));
        parent::assertTrue(self::$initialValueOfGlobal === $_FILES);
        //parent::assertTrue(self::$initialValueOfAutoProperty === self::$testObject->autoProperty);
        parent::assertTrue(self::$initialValueOfAutoProperty === \tests_PEAR_AClass::$objectProperty->autoProperty);
        parent::assertTrue(self::$initialValueOfStaticProperty === \tests_PEAR_AClass::$staticProperty);
        //parent::assertTrue(B::clearRecursiveArrayElement(\tests_PEAR_AClass::$recursiveStaticProperty) === B::clearRecursiveArrayElement(self::$initialValueOfRecursiveStaticProperty));
        // Changes the value and the reference.
        $_FILES = &$referenceChange2;
        $_FILES = 'The change value of global variable. 2';
        //self::$testObject->autoProperty = 'The change value of auto property. 2';
        \tests_PEAR_AClass::$objectProperty->autoProperty = 'The change value of auto property. 2';
        \tests_PEAR_AClass::$staticProperty = 'The change value of static property. 2';
        //\tests_PEAR_AClass::$recursiveStaticProperty = 'The change value of recursive static property. 2';
    }

}
