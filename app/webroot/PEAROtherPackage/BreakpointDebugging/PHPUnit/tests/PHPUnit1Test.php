<?php

use \BreakpointDebugging_PHPUnit as BU;

class PHPUnit1Test extends \BreakpointDebugging_PHPUnit_FrameworkTestCase
{
    static $initialValueOfGlobal;
    static $initialReferenceOfGlobal;
    static $initialValueOfAutoProperty;
    static $initialValueOfStaticProperty;

    static function setUpBeforeClass()
    {
        BU::includeClass('AClass3.php');
        BU::loadClass('AClass');
        //BU::loadClass('tests_PEAR_AClass2');
        BU::loadClass('AClass2');
        parent::setUpBeforeClass();
    }

    protected function setUp()
    {
        parent::setUp();

        //new \tests_PEAR_AClass(); // For static property registration with object to static backup.
        new \AClass(); // For static property registration with object to static backup.
    }

    /**
     * @covers \Example<extended>
     */
    public function testStoring_A()
    {
        // Stores the initial value and the initial reference.
        self::$initialReferenceOfGlobal = &$_FILES;
        self::$initialValueOfGlobal = $_FILES;
        //self::$initialValueOfAutoProperty = \tests_PEAR_AClass::$objectProperty->autoProperty;
        self::$initialValueOfAutoProperty = \AClass::$objectProperty->autoProperty;
        //self::$initialValueOfStaticProperty = \tests_PEAR_AClass::$staticProperty;
        self::$initialValueOfStaticProperty = \AClass::$staticProperty;
        // Changes the value and the reference.
        $_FILES = &$referenceChange;
        $_FILES = 'The change value of global variable.';
        //\tests_PEAR_AClass::$objectProperty->autoProperty = 'The change value of auto property.';
        \AClass::$objectProperty->autoProperty = 'The change value of auto property.';
        //\tests_PEAR_AClass::$staticProperty = 'The change value of static property.';
        \AClass::$staticProperty = 'The change value of static property.';
    }

    /**
     * @covers \Example<extended>
     */
    public function testStoring_B()
    {
        // Asserts the value and the reference.
        parent::assertTrue(array (&self::$initialReferenceOfGlobal) === array (&$_FILES));
        parent::assertTrue(self::$initialValueOfGlobal === $_FILES);
        //parent::assertTrue(self::$initialValueOfAutoProperty === \tests_PEAR_AClass::$objectProperty->autoProperty);
        parent::assertTrue(self::$initialValueOfAutoProperty === \AClass::$objectProperty->autoProperty);
        //parent::assertTrue(self::$initialValueOfStaticProperty === \tests_PEAR_AClass::$staticProperty);
        parent::assertTrue(self::$initialValueOfStaticProperty === \AClass::$staticProperty);
        // Changes the value and the reference.
        $_FILES = &$referenceChange2;
        $_FILES = 'The change value of global variable. 2';
        //\tests_PEAR_AClass::$objectProperty->autoProperty = 'The change value of auto property. 2';
        \AClass::$objectProperty->autoProperty = 'The change value of auto property. 2';
        //\tests_PEAR_AClass::$staticProperty = 'The change value of static property. 2';
        \AClass::$staticProperty = 'The change value of static property. 2';
    }

}
