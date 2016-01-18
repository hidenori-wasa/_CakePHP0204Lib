<?php

// >
use \BreakpointDebugging as B;
use \BreakpointDebugging_PHPUnit as BU;
use \BreakpointDebugging_PHPUnit_docs_examples_Sub_Example as BUE;

B::assert(B::isDebug());
class BreakpointDebugging_PHPUnit_docs_examples_Sub_ExampleTestSimple extends \BreakpointDebugging_PHPUnit_FrameworkTestCaseSimple
{
    private $_pTestObject;

    static function setUpBeforeClass()
    {
        BU::loadClass('BreakpointDebugging_PHPUnit_docs_examples_Sub_Example');
        parent::setUpBeforeClass();
    }

    protected function setUp()
    {
        // This is required at top.
        parent::setUp();

        // A test instance must be constructed here.
        $this->_pTestObject = new BUE();
    }

    protected function tearDown()
    {
        // Destructs the test instance to reduce memory use. Also, this is the rule 1.
        $this->_pTestObject = null;

        // This is required at bottom.
        parent::tearDown();
    }

    function testExpampleMethodA()
    {
        $result = BUE::expampleMethodA();

        parent::assertTrue($result === false);
    }

    function testExpampleMethodB_1()
    {
        BU::ignoreBreakpoint();
        try {
            $this->_pTestObject->expampleMethodB('STRING');
        } catch (\BreakpointDebugging_ErrorException $e) {
            BU::assertExceptionMessage($e, 'CLASS=BreakpointDebugging_PHPUnit_docs_examples_Sub_Example FUNCTION=expampleMethodB ID=101.');
            return;
        }
        parent::fail();
    }

    function testExpampleMethodB_2()
    {
        BU::setRelease();
        try {
            $this->_pTestObject->expampleMethodB('STRING');
        } catch (\BreakpointDebugging_ErrorException $e) {
            BU::assertExceptionMessage($e, 'CLASS=BreakpointDebugging_PHPUnit_docs_examples_Sub_Example FUNCTION=expampleMethodB ID=102.');
            return;
        }
        parent::fail();
    }

    function testExpampleMethodB_3()
    {
        try {
            $this->_pTestObject->expampleMethodB(1);
        } catch (\BreakpointDebugging_ErrorException $e) {
            BU::assertExceptionMessage($e, 'CLASS=BreakpointDebugging_PHPUnit_docs_examples_Sub_Example FUNCTION=expampleMethodB ID=1.');
            return;
        }
        parent::fail();
    }

    function test_expampleMethodC()
    {
        try {
            BU::callForTest(array (
                'objectOrClassName' => 'BreakpointDebugging_PHPUnit_docs_examples_Sub_Example',
                'methodName' => '_expampleMethodC',
                'params' => array ()
            ));
        } catch (\BreakpointDebugging_ErrorException $e) {
            BU::assertExceptionMessage($e, 'CLASS=BreakpointDebugging_PHPUnit_docs_examples_Sub_Example FUNCTION=_expampleMethodC ID=101.');
            return;
        }
        parent::fail();
    }

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

    function testInitialize()
    {
        BUE::initialize(1);
    }

}
