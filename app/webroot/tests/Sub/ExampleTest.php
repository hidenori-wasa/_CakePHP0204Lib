<?php

use \BreakpointDebugging as B;
use \BreakpointDebugging_PHPUnit as BU;

B::assert(B::isDebug());
// class Sub_ExampleTest extends \CakeTestCase // If "CakePHP". Or, "extends \ControllerTestCase".
class Sub_ExampleTest extends \BreakpointDebugging_PHPUnit_FrameworkTestCase
{
    private $_pTestObject;

    static function setUpBeforeClass()
    {
        class_exists('Sub_Example');
        parent::setUpBeforeClass();
    }

    protected function setUp()
    {
        // This is required at top.
        parent::setUp();

        // We must construct the test instance here.
        $this->_pTestObject = new \Sub_Example();
    }

    protected function tearDown()
    {
        // Destructs the test instance to reduce memory use. Also, this is the rule 1.
        $this->_pTestObject = null;

        // This is required at bottom.
        parent::tearDown();
    }

    /**
     * @covers \Sub_ExampleTest<extended>
     */
    function testExpampleMethodA()
    {
        $result = \Sub_Example::expampleMethodA();

        parent::assertTrue($result === false);
    }

    /**
     * @covers \Sub_ExampleTest<extended>
     *
     * @expectedException        \BreakpointDebugging_ErrorException
     * @expectedExceptionMessage CLASS=Sub_Example FUNCTION=expampleMethodB ID=101.
     */
    function testExpampleMethodB_1()
    {
        BU::ignoreBreakpoint();
        $this->_pTestObject->expampleMethodB('STRING');
    }

    /**
     * @covers \Sub_ExampleTest<extended>
     *
     * @expectedException        \BreakpointDebugging_ErrorException
     * @expectedExceptionMessage CLASS=Sub_Example FUNCTION=expampleMethodB ID=102.
     */
    function testExpampleMethodB_2()
    {
        BU::setRelease();
        $this->_pTestObject->expampleMethodB('STRING');
    }

    /**
     * @covers \Sub_ExampleTest<extended>
     *
     * @expectedException        \BreakpointDebugging_ErrorException
     * @expectedExceptionMessage CLASS=Sub_Example FUNCTION=expampleMethodB ID=1.
     */
    function testExpampleMethodB_3()
    {
        $this->_pTestObject->expampleMethodB(1);
    }

    /**
     * @covers \Sub_ExampleTest<extended>
     *
     * @expectedException        \BreakpointDebugging_ErrorException
     * @expectedExceptionMessage CLASS=Sub_Example FUNCTION=_expampleMethodC ID=101.
     */
    function test_expampleMethodC()
    {
        BU::callForTest(array (
            'objectOrClassName' => 'Sub_Example',
            'methodName' => '_expampleMethodC',
            'params' => array ()
        ));
    }

    /**
     * @covers \Sub_ExampleTest<extended>
     */
    function test_expampleMethodD()
    {
        $tmp = 'DUMMY';
        $result = BU::callForTest(array (
                'objectOrClassName' => $this->_pTestObject,
                'methodName' => '_expampleMethodD',
                'params' => array (&$tmp)
        ));

        parent::assertTrue($result === true);
    }

    /**
     * @covers \Sub_ExampleTest<extended>
     */
    function testInitialize()
    {
        \Sub_Example::initialize(1);
    }

}
