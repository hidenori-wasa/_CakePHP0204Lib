<?php

\App::uses('AClass', 'WasaPhpUnit.Test/Case/');
class PHPUnit1Test extends \CakeTestCase
{
    static $initialValueOfGlobal;
    static $initialReferenceOfGlobal;
    static $initialValueOfAutoProperty;
    static $initialValueOfStaticProperty;
    static $initialValueOfRecursiveStaticProperty;
    private $_testObject;

    function setUp()
    {
        parent::setUp();

        $this->_testObject = new \AClass();
    }

    function tearDown()
    {
        $this->_testObject = null;

        parent::tearDown();
    }

    /**
     * @covers \Example<extended>
     */
    public function testStoring_A()
    {
        // Stores the initial value and the initial reference.
        self::$initialReferenceOfGlobal = &$_FILES;
        self::$initialValueOfGlobal = $_FILES;
        self::$initialValueOfAutoProperty = $this->_testObject->autoProperty;
        self::$initialValueOfStaticProperty = \AClass::$staticProperty;
        self::$initialValueOfRecursiveStaticProperty = \AClass::$recursiveStaticProperty;

        // Changes the value and the reference.
        $_FILES = &$referenceChange;
        $_FILES = 'The change value of global variable.';
        $this->_testObject->autoProperty = 'The change value of auto property.';
        \AClass::$staticProperty = 'The change value of static property.';
        \AClass::$recursiveStaticProperty = 'The change value of recursive static property.';
    }

    /**
     * @covers \Example<extended>
     */
    public function testStoring_B()
    {
        // Asserts the value and the reference.
        parent::assertTrue(array (&self::$initialReferenceOfGlobal) === array (&$_FILES));
        parent::assertTrue(self::$initialValueOfGlobal === $_FILES);
        parent::assertTrue(self::$initialValueOfAutoProperty === $this->_testObject->autoProperty);
        parent::assertTrue(self::$initialValueOfStaticProperty === \AClass::$staticProperty);
        // Changes the value and the reference.
        $_FILES = &$referenceChange2;
        $_FILES = 'The change value of global variable. 2';
        $this->_testObject->autoProperty = 'The change value of auto property. 2';
        \AClass::$staticProperty = 'The change value of static property. 2';
        \AClass::$recursiveStaticProperty = 'The change value of recursive static property. 2';
    }

}
