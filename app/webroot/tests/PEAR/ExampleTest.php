<?php

/**
 * Please, see "Coding rule." section of "PEAR/BreakpointDebugging/PHPUnit/BREAKPOINTDEBUGGING_PHPUNIT_MANUAL.html" for detail.
 */
use \BreakpointDebugging as B;
use \BreakpointDebugging_PHPUnit as BU;

function localStaticVariable()
{
    // static $localStatic = 'Local static value.'; // We must not define local static variable of function. (Autodetects)
}

class LocalStaticVariableOfStaticMethod
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
// $something = 'Defines global variable.'; // The rule to keep static status: Static status must not be changed at file load. (Does not autodetect)
//
// $_FILES = 'Changes the value.'; // The same to above. (Does not autodetect)
//
// $_FILES = &$bugReference; // The rule to keep static status: Static status must not be overwritten with reference at file load. (Does not autodetect)
// unset($bugReference);
//
// unset($_FILES); // The rule to keep static status: Static status must not be deleted at file load. (Does not autodetect)
//
// include_once 'tests/PEAR/AFile.php'; // The rule to keep static status: "include" must not be executed at file load because a class may be declared newly. (Does not autodetect)
class ExampleTest extends \BreakpointDebugging_PHPUnit_FrameworkTestCase
{
    private $_pTestObject;

    static function loadClass($className)
    {

    }

    static function setUpBeforeClass()
    {
        // global $something;
        // $something = 'Defines global variable.'; // The rule to keep static status: Static status must not be changed before static backup. (Does not autodetect)
        //
        // $_FILES = 'Changes the value.'; // The same to above. (Does not autodetect)
        //
        // $_FILES = &$bugReference; // The rule to keep static status: Static status must not be overwritten with reference before static backup. (Does not autodetect)
        //
        // unset($_FILES); // The rule to keep static status: Static status must not be deleted before static backup. (Does not autodetect)
        //
        // Please, preload classes by copying error display. Also, preloaded class files must apply to "Coding rule". (Autodetects)
        BU::loadClass('BreakpointDebugging_LockByFlock');
        // BU::includeClass('tests/PEAR/AFile.php');
        //
        //BU::loadClass('BreakpointDebugging_LockByFileExisting');
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
        // For debug. ===>
        $variableRefsStorage = &\BreakpointDebugging_PHPUnit_StaticVariableStorage::refGlobalRefs();
        if (array_key_exists('_FILES', $variableRefsStorage) && array (&$_FILES) !== array (&$variableRefsStorage['_FILES'])) {
            xdebug_break();
        }
        // <=== For debug.

        $_FILES = 'Changes the value 2.'; // We can change global variable and static property here.
        // For debug. ===>
        $variableRefsStorage = &\BreakpointDebugging_PHPUnit_StaticVariableStorage::refGlobalRefs();
        if (array_key_exists('_FILES', $variableRefsStorage) && array (&$_FILES) !== array (&$variableRefsStorage['_FILES'])) {
            xdebug_break();
        }
        // <=== For debug.

        $_FILES = &$aReference2; // We can overwrite global variable except static property with reference here.
        // For debug. ===>
        $variableRefsStorage = &\BreakpointDebugging_PHPUnit_StaticVariableStorage::refGlobalRefs();
        if (array_key_exists('_FILES', $variableRefsStorage) && array (&$_FILES) === array (&$variableRefsStorage['_FILES'])) {
            xdebug_break();
        }
        // <=== For debug.

        unset($_FILES); // We can delete global variable here.
        //
        // For debug. ===>
        $variableRefsStorage = &\BreakpointDebugging_PHPUnit_StaticVariableStorage::refGlobalRefs();
        if (array_key_exists('_FILES', $variableRefsStorage) && array (&$_FILES) === array (&$variableRefsStorage['_FILES'])) {
            xdebug_break();
        }
        // <=== For debug.
        //
        // spl_autoload_unregister('\ExampleTest::loadClass');
        // spl_autoload_register('\ExampleTest::loadClass', true, true); // We must not register autoload function at top of stack by "spl_autoload_register()". (Autodetects)
        //
        // include_once __DIR__ . '/AFile.php'; // "include" must not be executed during "setUp()", "test*()" or "tearDown()" because a class is declared newly. (Autodetects)
    }

    protected function tearDown()
    {
        // spl_autoload_unregister('\ExampleTest::loadClass');
        // spl_autoload_register('\ExampleTest::loadClass', true, true); // We must not register autoload function at top of stack by "spl_autoload_register()". (Autodetects)
        //
        // Destructs the test instance to reduce memory use.
        $this->_pTestObject = null;

        // This line is required at bottom.
        parent::tearDown();
    }

    function isCalled()
    {
        throw new \BreakpointDebugging_ErrorException('Something message.', 101); // This is reflected in "@expectedException" and "@expectedExceptionMessage".
    }

    /**
     * @covers \Example<extended>
     *
     * @expectedException        \BreakpointDebugging_ErrorException
     * @expectedExceptionMessage CLASS=ExampleTest FUNCTION=isCalled ID=101.
     */
    public function testSomething_A()
    {
        global $something;
        $something = 'Defines global variable 3.'; // We can define global variable here.
        // For debug. ===>
        $variableRefsStorage = &\BreakpointDebugging_PHPUnit_StaticVariableStorage::refGlobalRefs();
        if (array_key_exists('_FILES', $variableRefsStorage) && array (&$_FILES) === array (&$variableRefsStorage['_FILES'])) {
            xdebug_break();
        }
        // <=== For debug.

        $_FILES = 'Changes the value 3.'; // We can change global variable and static property here.
        // For debug. ===>
        $variableRefsStorage = &\BreakpointDebugging_PHPUnit_StaticVariableStorage::refGlobalRefs();
        if (array_key_exists('_FILES', $variableRefsStorage) && array (&$_FILES) === array (&$variableRefsStorage['_FILES'])) {
            xdebug_break();
        }
        // <=== For debug.

        $_FILES = &$aReference3; // We can overwrite global variable except static property with reference here.
        // For debug. ===>
        $variableRefsStorage = &\BreakpointDebugging_PHPUnit_StaticVariableStorage::refGlobalRefs();
        if (array_key_exists('_FILES', $variableRefsStorage) && array (&$_FILES) === array (&$variableRefsStorage['_FILES'])) {
            xdebug_break();
        }
        // <=== For debug.

        unset($_FILES); // We can delete global variable here.
        // For debug. ===>
        $variableRefsStorage = &\BreakpointDebugging_PHPUnit_StaticVariableStorage::refGlobalRefs();
        if (array_key_exists('_FILES', $variableRefsStorage) && array (&$_FILES) === array (&$variableRefsStorage['_FILES'])) {
            xdebug_break();
        }
        // <=== For debug.
        //
        // spl_autoload_unregister('\ExampleTest::loadClass');
        // spl_autoload_register('\ExampleTest::loadClass', true, true); // We must not register autoload function at top of stack by "spl_autoload_register()". (Autodetects)
        //
        // include_once __DIR__ . '/AFile.php'; // "include" must not be executed during "setUp()", "test*()" or "tearDown()" because a class is declared newly. (Autodetects)

        BU::markTestSkippedInDebug();

        // Destructs the instance.
        $this->_pTestObject = null;

        BU::ignoreBreakpoint();
        $this->isCalled();
    }

    /**
     * @covers \Example<extended>
     */
    public function testSomething_B()
    {
        BU::markTestSkippedInRelease();

        // How to use "try-catch" syntax instead of "@expectedException" and "@expectedExceptionMessage".
        // This way can test an error after static status was changed.
        try {
            B::assert(true, 101);
            B::assert(false, 102);
        } catch (\BreakpointDebugging_ErrorException $e) {
            BU::assertExceptionMessage($e, 'CLASS=ExampleTest FUNCTION=testSomething_B ID=102.');
            return;
        }
        parent::fail();
    }

    /**
     * @covers \Example<extended>
     */
    public function testIncompletedColor()
    {
        // parent::markTestIncomplete();
    }

}
