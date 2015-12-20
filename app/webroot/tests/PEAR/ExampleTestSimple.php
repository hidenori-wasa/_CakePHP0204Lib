<?php

/**
 * Please, see "Coding rule." section of "PEAR/BreakpointDebugging/PHPUnit/BREAKPOINTDEBUGGING_PHPUNIT_MANUAL.html" for detail.
 */
use \BreakpointDebugging as B;
use \BreakpointDebugging_PHPUnit as BU;

function localStaticVariable2()
{
    // static $localStatic = 'Local static value.'; // We must not define local static variable of function. (Autodetects)
}

class LocalStaticVariableOfStaticMethod2
{
    static $staticProperty = 'Initial value.'; // We can define static property here.

    static function localStaticVariable()
    {
        // static $localStatic = 'Local static value.'; // We must not define local static variable of static class method. (Autodetects)
    }

    function localStaticVariableOfInstance()
    {
        // static $localStatic = 'Local static value.'; // We must not define local static variable of auto class method. (Autodetects)
    }

}

// global $something;
// $something = 'Defines global variable.'; // The rule to keep static status: We must not define global variable in global scope. (Does not autodetect)
//
// $_FILES = 'Changes the value.'; // The rule to keep static status: We must not change global variable and static property in global scope. (Does not autodetect)
//
// $_FILES = &$bugReference; // The rule to keep static status: We must not overwrite global variable and static property with reference in global scope. (Does not autodetect)
// unset($bugReference);
//
// unset($_FILES); // The rule to keep static status: We must not delete global variable in global scope. (Does not autodetect)
//
// include_once 'tests/PEAR/AFile.php'; // The rule to keep static status: "include" must not be executed in global scope because a class may be declared newly. (Does not autodetect)
class ExampleTestSimple extends \BreakpointDebugging_PHPUnit_FrameworkTestCaseSimple
{
    private $_pTestObject;

    static function loadClass($className)
    {

    }

    static function setUpBeforeClass()
    {
        // global $something;
        // $something = 'Defines global variable.'; // The rule to keep static status: We must not define global variable before static backup. (Does not autodetect)
        //
        // $_FILES = 'Changes the value.'; // The rule to keep static status: We must not change global variable and static property before static backup. (Does not autodetect)
        //
        // $_FILES = &$bugReference; // The rule to keep static status: We must not overwrite global variable and static property with reference before static backup. (Does not autodetect)
        //
        // unset($_FILES); // The rule to keep static status: We must not delete global variable before static backup. (Does not autodetect)
        //
        // Please, preload classes by copying error display.
        class_exists('BreakpointDebugging_LockByFlock');
        // include_once 'tests/PEAR/AFile.php';
        //
        // Stores static backup here. This line is required at bottom.
        parent::setUpBeforeClass();
    }

    static function tearDownAfterClass()
    {
        parent::tearDownAfterClass(); // Requires parent.
    }

    protected function setUp()
    {
        // This line is required at top.
        parent::setUp();

        // We must construct the test instance here.
        $this->_pTestObject = &BreakpointDebugging_LockByFlock::singleton();

        global $something;
        $something = 'Defines global variable 2.'; // We can define global variable here.

        $_FILES = 'Changes the value 2.'; // We can change global variable and static property here.

        $_FILES = &$aReference2; // We can overwrite global variable except static property with reference here.

        unset($_FILES); // We can delete global variable here.
        //
        // spl_autoload_unregister('\ExampleTestSimple::loadClass');
        // spl_autoload_register('\ExampleTestSimple::loadClass', true, true); // We must not register autoload function at top of stack by "spl_autoload_register()". (Autodetects)
        //
        // include_once __DIR__ . '/AFile.php'; // "include" must not be executed during "setUp()", "test*()" or "tearDown()" because a class is declared newly. (Autodetects)
    }

    protected function tearDown()
    {
        // spl_autoload_unregister('\ExampleTestSimple::loadClass');
        // spl_autoload_register('\ExampleTestSimple::loadClass', true, true); // We must not register autoload function at top of stack by "spl_autoload_register()". (Autodetects)
        //
        // Destructs the test instance to reduce memory use.
        $this->_pTestObject = null;

        // This line is required at bottom.
        parent::tearDown();
    }

    function isCalled()
    {
        throw new \BreakpointDebugging_ErrorException('Something message.', 101); // This is not reflected in "@expectedException" and "@expectedExceptionMessage".
    }

    public function testSomething_A()
    {
        global $something;
        $something = 'Defines global variable 3.'; // We can define global variable here.

        $_FILES = 'Changes the value 3.'; // We can change global variable and static property here.

        $_FILES = &$aReference3; // We can overwrite global variable except static property with reference here.

        unset($_FILES); // We can delete global variable here.
        //
        // spl_autoload_unregister('\ExampleTestSimple::loadClass');
        // spl_autoload_register('\ExampleTestSimple::loadClass', true, true); // We must not register autoload function at top of stack by "spl_autoload_register()". (Autodetects)
        //
        // include_once __DIR__ . '/AFile.php'; // "include" must not be executed during "setUp()", "test*()" or "tearDown()" because a class is declared newly. (Autodetects)
        if (parent::markTestSkippedInDebug()) {
            return;
        }

        // Destructs the instance.
        $this->_pTestObject = null;

        BU::ignoreBreakpoint();
        try {
            $this->isCalled();
        } catch (\BreakpointDebugging_ErrorException $e) {
            BU::assertExceptionMessage($e, 'CLASS=ExampleTestSimple FUNCTION=isCalled ID=101.');
            return;
        }
        parent::fail();
    }

    public function testSomething_B()
    {
        if (parent::markTestSkippedInRelease()) {
            return;
        }

        // How to use "try-catch" syntax instead of "@expectedException" and "@expectedExceptionMessage".
        // This way can test an error after static status was changed.
        try {
            B::assert(true, 101);
            B::assert(false, 102);
        } catch (\BreakpointDebugging_ErrorException $e) {
            BU::assertExceptionMessage($e, 'CLASS=ExampleTestSimple FUNCTION=testSomething_B ID=102.');
            return;
        }
        parent::fail();
    }

}
