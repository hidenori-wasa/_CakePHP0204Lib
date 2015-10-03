<?php

use \BreakpointDebugging as B;
use \BreakpointDebugging_PHPUnit as BU;

/**
 * Test class for BreakpointDebugging_Error.
 * Generated by PHPUnit on 2013-02-17 at 07:57:23.
 */
class BreakpointDebugging_ErrorTest extends \BreakpointDebugging_PHPUnit_FrameworkTestCase
{
    private $_error;

    function setUp()
    {
        parent::setUp();

        $this->_error = new \BreakpointDebugging_Error();
    }

    function tearDown()
    {
        $this->_error = null;

        parent::tearDown();
    }

    /**
     * @covers \BreakpointDebugging_Error<extended>
     */
    function test__construct()
    {
        $store = B::getXebugExists();

        B::setXebugExists(true);
        new \BreakpointDebugging_Error();

        B::setXebugExists(false);
        new \BreakpointDebugging_Error();

        B::setXebugExists($store);
    }

    function throwException2()
    {
        throw new \Exception();
    }

    /**
     * @covers \BreakpointDebugging_Error<extended>
     */
    public function testHandleException2()
    {
        ob_start();

        //$maxLogStringSize = &B::refStatic('$_maxLogStringSize');
        $maxLogStringSize = &B::refMaxLogStringSize();
        $maxLogStringSize = 140000;

        $exceptionWithGLOBALS = function ($self) {
            try {
                B::addValuesToTrace(array (array ('TestString')));
                $self->throwException2($GLOBALS, array ('Test1.'));
            } catch (\Exception $e) {
                B::handleException($e);
            }
        };

        $logfileMaximumCapacityException = function ($self) {
            try {
                $self->throwException2(str_repeat('1234567890', 14000), array ('Test1.'), 1.1);
            } catch (\Exception $e) {
                B::handleException($e);
            }
        };

        //BU::$exeMode |= B::IGNORING_BREAK_POINT;
        BU::ignoreBreakpoint();
        BU::$exeMode ^= B::REMOTE;
        $exceptionWithGLOBALS($this);
        $logfileMaximumCapacityException($this);

        BU::$exeMode ^= B::REMOTE;
        $exceptionWithGLOBALS($this);
        $logfileMaximumCapacityException($this);
    }

    /**
     * @covers \BreakpointDebugging_Error<extended>
     */
    function testHandleException2_B()
    {
        ob_start();
        //BU::$exeMode |= B::IGNORING_BREAK_POINT;
        BU::ignoreBreakpoint();
        try {
            // SJIS + UTF-8
            $this->_error->handleException2(new \Exception(), "\x95\xB6\x8E\x9A \xE6\x96\x87\xE5\xAD\x97 ");
        } catch (\BreakpointDebugging_ErrorException $e) {
            BU::assertExceptionMessage($e, 'CLASS=BreakpointDebugging_ErrorInAllCase FUNCTION=convertMbString ID=3.');
        }

        // Skips "\BreakpointDebugging_Error::convertMbString()" "SJIS + UTF-8" error exception.
        $this->_error->handleException2(new \Exception(), "\x95\xB6\x8E\x9A \xE6\x96\x87\xE5\xAD\x97 ");
    }

    function exceptionHandler2_D()
    {
        throw new \Exception();
    }

    /**
     * @covers \BreakpointDebugging_Error<extended>
     */
    function testHandleException2_D()
    {
        ob_start();
        try {
            $this->exceptionHandler2_D($GLOBALS);
        } catch (\Exception $e) {
            //BU::$exeMode |= B::IGNORING_BREAK_POINT;
            BU::ignoreBreakpoint();
            // Skips the global variable array.
            $this->_error->handleException2($e, '');
        }
    }

    /**
     * @covers \BreakpointDebugging_Error<extended>
     */
    public function testHandleError2()
    {
        ob_start();
        //BU::$exeMode |= B::IGNORING_BREAK_POINT;
        BU::ignoreBreakpoint();
        B::handleError(E_USER_WARNING, '');
    }

    /**
     * @covers \BreakpointDebugging_Error<extended>
     *
     * @expectedException        \BreakpointDebugging_ErrorException
     * @expectedExceptionMessage CLASS=BreakpointDebugging_ErrorInAllCase FUNCTION=handleError2 ID=5.
     */
    function testHandleError2_B()
    {
        ob_start();
        //BU::$exeMode |= B::IGNORING_BREAK_POINT;
        BU::ignoreBreakpoint();
        $this->_error->handleError2(-1, '', B::$prependErrorLog, debug_backtrace());
    }

}

?>
