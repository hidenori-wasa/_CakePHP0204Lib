<?php

require_once './BreakpointDebugging_Inclusion.php';

// "use" syntax's alias has file scope except file which is including and is included.
// And, it has highest priority.
// Therefore, it is not affected by other class name.
use \BreakpointDebugging as B;

class Sub_Example
{
    private static $_something;

    static function expampleMethodA()
    {
        return false;
    }

    function expampleMethodB($param1)
    {
        // We should use "\BreakpointDebugging" in "assert()" class method because this is commented out in production mode.
        \BreakpointDebugging::assert(is_string($param1), 1);

        // A code both debug and release...
        // If debug execution mode.
        // We should use "\BreakpointDebugging" in "isDebug()" class method because this is replaced to literal on production mode.
        if (\BreakpointDebugging::isDebug()) {
            // A debug code...
            B::breakpoint('Error message.', debug_backtrace());
            throw new \BreakpointDebugging_ErrorException('An error exception.', 101);
        } else { // If release execution mode.
            // A release code...
            throw new \BreakpointDebugging_ErrorException('An error exception.', 102);
        }
    }

    private static function _expampleMethodC()
    {
        throw new \BreakpointDebugging_ErrorException('An error exception.', 101);
    }

    private function _expampleMethodD(&$param)
    {
        // The file search detection rule 1.
        self::$_something[0] = &$param;

        return true;
    }

    /**
     * The file search detection rule 2.
     * @codeCoverageIgnore
     */
    function notTestMethod()
    {
        null;
    }

    static function initialize($param)
    {
        // This is not rule violation because this line is executed at autoload.
        self::$_something = &$param;
    }

}

if (B::isTopPage()) { // Skips the following if unit test execution.
    // @codeCoverageIgnoreStart
    Example::initialize(1);
}
// @codeCoverageIgnoreEnd