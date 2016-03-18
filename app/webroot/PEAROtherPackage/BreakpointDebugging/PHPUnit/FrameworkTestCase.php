<?php

/**
 * Debugs unit tests code continuously by IDE. With "\BreakpointDebugging_PHPUnit::executeUnitTest()" class method. Supports "php" version 5.3.0 since then.
 *
 * Copyright (c) 2001-2015, Sebastian Bergmann <sebastian@phpunit.de>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Sebastian Bergmann nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category   PHPUnit
 * @package    PHPUnit
 * @subpackage Framework
 * @author     Sebastian Bergmann <sebastian@phpunit.de>
 * @copyright  2001-2015 Sebastian Bergmann <sebastian@phpunit.de>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link       http://www.phpunit.de/
 * @since      File available since Release 2.0.0
 */
use \BreakpointDebugging as B;
use \BreakpointDebugging_Window as BW;
use \BreakpointDebugging_PHPUnit as BU;
use \BreakpointDebugging_PHPUnit_StaticVariableStorage as BSS;
use \BreakpointDebugging_PHPUnit_FrameworkTestCaseSimple as BTCS;

/**
 * Debugs unit tests code continuously by IDE. With "\BreakpointDebugging_PHPUnit::executeUnitTest()" class method. Supports "php" version 5.3.0 since then.
 *
 * PHP version 5.3.2-5.4.x
 *
 * This class extends "PHPUnit_Framework_TestCase".
 * Also, we can execute unit test with remote server without installing "PHPUnit".
 *
 * ### About "PHPUnit" package component. ###
 * I copied following "PHPUnit" package files into "BreakpointDebugging/Component/" directory
 * because it avoids "PHPUnit" package version control.
 *      PEAR/PHP/CodeCoverage.php
 *      PEAR/PHP/CodeCoverage/
 *          Copyright (c) 2009-2012 Sebastian Bergmann <sb@sebastian-bergmann.de>
 *      PEAR/PHP/Invoker.php
 *      PEAR/PHP/Invoker/
 *          Copyright (c) 2011-2012 Sebastian Bergmann <sb@sebastian-bergmann.de>
 *      PEAR/PHP/Timer.php
 *      PEAR/PHP/Timer/
 *          Copyright (c) 2010-2011 Sebastian Bergmann <sb@sebastian-bergmann.de>
 *      PEAR/PHP/Token.php
 *      PEAR/PHP/Token/
 *          Copyright (c) 2009-2012 Sebastian Bergmann <sb@sebastian-bergmann.de>
 *      PEAR/PHPUnit/
 *          Copyright (c) 2001-2012 Sebastian Bergmann <sebastian@phpunit.de>
 * Then, I added "Hidenori Wasa added." to line which I coded into "BreakpointDebugging/Component/" directory.
 *
 * @category   PHPUnit
 * @package    PHPUnit
 * @subpackage Framework
 * @author     Sebastian Bergmann <sebastian@phpunit.de>
 * @copyright  2001-2015 Sebastian Bergmann <sebastian@phpunit.de>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: 3.6.12
 * @link       http://www.phpunit.de/
 * @since      Class available since Release 2.0.0
 */
class BreakpointDebugging_PHPUnit_FrameworkTestCase extends \PHPUnit_Framework_TestCase
{

    /**
     * This class method is called first per "*TestSimple.php" file.
     *
     * @return void
     */
    static function setUpBeforeClass()
    {
        // Loads a class file.
        class_exists('\PHP_Timer');
        BTCS::setUpBeforeClass();
    }

    /**
     * This class method is called lastly per "*Test.php" file.
     *
     * @return void
     */
    public static function tearDownAfterClass()
    {
        BTCS::tearDownAfterClass();
    }

    /**
     * This method is called before a test class method is executed.
     * Sets up initializing which is needed at least in unit test.
     *
     * @return void
     * @author Hidenori Wasa <public@hidenori-wasa.com>
     */
    protected function setUp()
    {
        parent::setUp();

        BTCS::setUpBase();
    }

    /**
     * This method is called after a test class method is executed.
     * Cleans up environment which is needed at least in unit test.
     *
     * @return void
     * @author Hidenori Wasa <public@hidenori-wasa.com>
     */
    protected function tearDown()
    {
        BTCS::tearDownBase();

        parent::tearDown();
    }

    /**
     * Checks a document comment existence.
     *
     * @return void
     * @author Hidenori Wasa <public@hidenori-wasa.com>
     */
    private function _checkDocCommentExistence()
    {
        $className = get_class($this);
        $methodName = $this->name;
        $errorMessage = '"' . $className . '::' . $methodName . '" unit test class method requires ';
        $methodReflection = new ReflectionMethod($className, $methodName);
        $docComment = $methodReflection->getDocComment();
        if ($docComment === false) {
            B::exitForError($errorMessage . 'document comment.');
        }
    }

    /**
     * Overrides "\PHPUnit_Framework_TestCase::runBare()" to display call stack when error occurred.
     * Also, I changed storing and restoring class method.
     * And, I changed location which calls those.
     * So, it is "--static-backup" command line switch for continuous execution by IDE.
     *
     * @return void
     * @author Hidenori Wasa <public@hidenori-wasa.com>
     */
    public function runBare()
    {
        if (BU::getCodeCoverageKind() === 'SIMPLE_OWN') {
            // Resumes the code coverage report.
            xdebug_start_code_coverage(XDEBUG_CC_UNUSED | XDEBUG_CC_DEAD_CODE);
        }

        BU::displayProgress(5);

        $this->numAssertions = 0;
        // Gets test-class-name.
        $classReflection = new \ReflectionClass($this);
        $currentTestClassName = &BSS::refCurrentTestClassName();
        $currentTestClassName = $testClassName = $classReflection->name;
        $currentTestMethodName = &BSS::refCurrentTestMethodName();
        $currentTestMethodName = $this->getName();

        $refOnceFlagPerTestFile = &BSS::refOnceFlagPerTestFile();
        // If this is the first of test file.
        if ($refOnceFlagPerTestFile) {
            BU::displayProgress(300);
            $refOnceFlagPerTestFile = false;
            // Adds static backup black list of command line switch.
            $refBackupGlobalsBlacklist = &BSS::refBackupGlobalsBlacklist();
            $refBackupGlobalsBlacklist += $this->backupGlobalsBlacklist;
            $refBackupStaticPropertiesBlacklist = &BSS::refBackupStaticPropertiesBlacklist();
            $refBackupStaticPropertiesBlacklist += $this->backupStaticAttributesBlacklist;
            // Checks the autoload functions.
            BTCS::checkAutoloadFunctions($testClassName);
        }

        // Start output buffering.
        ob_start();
        $this->outputBufferingActive = true;

        // Clean up stat cache.
        clearstatcache();

        try {
            $this->setExpectedExceptionFromAnnotation();

            // Checks a document comment existence.
            $this->_checkDocCommentExistence();

            $this->setUp();

            // Checks the autoload functions.
            BTCS::checkAutoloadFunctions($testClassName, 'setUp');

            $this->checkRequirements();
            $this->assertPreConditions();

            if (BU::getCodeCoverageKind() === 'SIMPLE_OWN') {
                // Stops the code coverage report.
                xdebug_stop_code_coverage(false);
            }

            $this->testResult = $this->runTest();

            if (BU::getCodeCoverageKind() === 'SIMPLE_OWN') {
                // Resumes the code coverage report.
                xdebug_start_code_coverage(XDEBUG_CC_UNUSED | XDEBUG_CC_DEAD_CODE);
            }

            // Checks the autoload functions.
            BTCS::checkAutoloadFunctions($testClassName, $this->getName());

            $this->verifyMockObjects();
            $this->assertPostConditions();
            $this->status = PHPUnit_Runner_BaseTestRunner::STATUS_PASSED;
        } catch (PHPUnit_Framework_IncompleteTest $e) {
            // Checks the autoload functions.
            BTCS::checkAutoloadFunctions($testClassName, $this->getName());

            $this->status = PHPUnit_Runner_BaseTestRunner::STATUS_INCOMPLETE;
            $this->statusMessage = $e->getMessage();
        } catch (PHPUnit_Framework_SkippedTest $e) {
            // Checks the autoload functions.
            BTCS::checkAutoloadFunctions($testClassName, $this->getName());

            $this->status = PHPUnit_Runner_BaseTestRunner::STATUS_SKIPPED;
            $this->statusMessage = $e->getMessage();
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            B::exitForError($e); // Displays error call stack information.
        } catch (Exception $e) {
            B::exitForError($e); // Displays error call stack information.
        }

        // Tear down the fixture. An exception raised in tearDown() will be
        // caught and passed on when no exception was raised before.
        try {
            $this->tearDown();
            // Checks the autoload functions.
            BTCS::checkAutoloadFunctions($testClassName, 'tearDown');
        } catch (Exception $_e) {
            B::exitForError($_e); // Displays error call stack information.
        }

        // Checks an "include" error at "setUp()", "test*()" or "tearDown()".
        BSS::checkIncludeError();

        // Restores global variables.
        $refGlobalRefs = &BSS::refGlobalRefs();
        BSS::restoreGlobals($refGlobalRefs, BSS::refGlobals());
        // Restores static properties.
        BSS::restoreProperties(BSS::refStaticProperties());

        // Stop output buffering.
        if ($this->outputCallback === false) {
            $this->output = ob_get_contents();
        } else {
            $this->output = call_user_func_array($this->outputCallback, array (ob_get_contents()));
        }

        ob_end_clean();
        $this->outputBufferingActive = false;

        // Clean up stat cache.
        clearstatcache();

        // Clean up INI settings.
        foreach ($this->iniSettings as $varName => $oldValue) {
            ini_set($varName, $oldValue);
        }

        $this->iniSettings = array ();

        // Clean up locale settings.
        foreach ($this->locale as $category => $locale) {
            setlocale($category, $locale);
        }

        // Perform assertion on output.
        if (!isset($e)) {
            try {
                if ($this->outputExpectedRegex !== null) {
                    $this->hasPerformedExpectationsOnOutput = true;
                    $this->assertRegExp($this->outputExpectedRegex, $this->output);
                    $this->outputExpectedRegex = null;
                } else if ($this->outputExpectedString !== null) {
                    $this->hasPerformedExpectationsOnOutput = true;
                    $this->assertEquals($this->outputExpectedString, $this->output);
                    $this->outputExpectedString = null;
                }
            } catch (Exception $_e) {
                $e = $_e;
            }
        }

        // Workaround for missing "finally".
        if (isset($e)) {
            $this->onNotSuccessfulTest($e);
        }

        if (BU::getCodeCoverageKind() === 'SIMPLE_OWN') {
            // Stops the code coverage report.
            xdebug_stop_code_coverage(false);
        }
    }

    /**
     * Overrides "\PHPUnit_Framework_TestCase::runTest()" to display call stack when annotation failed.
     *
     * @return mixed
     * @throws RuntimeException
     * @author Hidenori Wasa <public@hidenori-wasa.com>
     */
    protected function runTest()
    {
        if (BU::getCodeCoverageKind() === 'SIMPLE_OWN') {
            // Resumes the code coverage report.
            xdebug_start_code_coverage(XDEBUG_CC_UNUSED | XDEBUG_CC_DEAD_CODE);
        }

        $name = $this->getName(false);
        if ($name === null) {
            throw new PHPUnit_Framework_Exception('PHPUnit_Framework_TestCase::$name must not be NULL.');
        }

        try {
            $class = new ReflectionClass($this);
            $method = $class->getMethod($name);
        } catch (ReflectionException $e) {
            $this->fail($e->getMessage());
        }

        try {
            $testResult = $method->invokeArgs($this, array_merge($this->data, $this->dependencyInput));
        } catch (Exception $e) {
            // If "\PHPUnit_Framework_Assert::markTestIncomplete()" was called, or if "\PHPUnit_Framework_Assert::markTestSkipped()" was called.
            if ($e instanceof PHPUnit_Framework_IncompleteTest //
                || $e instanceof PHPUnit_Framework_SkippedTest //
            ) {
                throw $e;
            }
            // If "@expectedException" annotation is not string.
            if (!is_string($this->getExpectedException())) {
                BW::htmlAddition(BU::getUnitTestWindowName(), 'pre', 0, '<b>It is error if this test has been not using "@expectedException" annotation, or it requires "@expectedException" annotation.</b>');
                B::exitForError($e); // Displays error call stack information.
            }
            // "@expectedException" annotation should be success.
            try {
                $this->assertThat($e, new PHPUnit_Framework_Constraint_Exception($this->getExpectedException()));
            } catch (Exception $dummy) {
                BW::htmlAddition(BU::getUnitTestWindowName(), 'pre', 0, '<b>Is error, or this test mistook "@expectedException" annotation value.</b>');
                B::exitForError($e); // Displays error call stack information.
            }
            // "@expectedExceptionMessage" annotation should be success.
            try {
                $expectedExceptionMessage = $this->expectedExceptionMessage;
                if (is_string($expectedExceptionMessage) //
                    && !empty($expectedExceptionMessage) //
                ) {
                    $this->assertThat($e, new PHPUnit_Framework_Constraint_ExceptionMessage($expectedExceptionMessage));
                }
            } catch (Exception $dummy) {
                BW::htmlAddition(BU::getUnitTestWindowName(), 'pre', 0, '<b>Is error, or this test mistook "@expectedExceptionMessage" annotation value.</b>');
                B::exitForError($e); // Displays error call stack information.
            }
            // "@expectedExceptionCode" annotation should be success.
            try {
                if ($this->expectedExceptionCode !== null) {
                    $this->assertThat($e, new PHPUnit_Framework_Constraint_ExceptionCode($this->expectedExceptionCode));
                }
            } catch (Exception $dummy) {
                BW::htmlAddition(BU::getUnitTestWindowName(), 'pre', 0, '<b>Is error, or this test mistook "@expectedExceptionCode" annotation value.</b>');
                B::exitForError($e); // Displays error call stack information.
            }

            if (BU::getCodeCoverageKind() === 'SIMPLE_OWN') {
                // Stops the code coverage report.
                xdebug_stop_code_coverage(false);
            }

            return;
        }
        if ($this->getExpectedException() !== null) {
            // "@expectedException" should not exist.
            BW::htmlAddition(BU::getUnitTestWindowName(), 'pre', 0, '<b>Is error in "' . $class->name . '::' . $name . '".</b>');

            $this->assertThat(null, new PHPUnit_Framework_Constraint_Exception($this->getExpectedException()));
        }

        if (BU::getCodeCoverageKind() === 'SIMPLE_OWN') {
            // Stops the code coverage report.
            xdebug_stop_code_coverage(false);
        }

        return $testResult;
    }

    /**
     * Overrides "\PHPUnit_Framework_Assert::assertTrue()" to display error call stack information.
     *
     * @param bool   $condition Conditional expression.
     * @param string $message   Error message.
     *
     * @return void
     * @author Hidenori Wasa <public@hidenori-wasa.com>
     */
    static function assertTrue($condition, $message = '')
    {
        B::assert(is_bool($condition));
        B::assert(is_string($message));

        try {
            parent::assertTrue($condition, $message);
        } catch (\Exception $e) {
            B::exitForError($e); // Displays error call stack information.
        }
    }

    /**
     * Overrides "\PHPUnit_Framework_Assert::fail()" to display error call stack information.
     *
     * @param string $message The fail message.
     *
     * @return void
     * @throws PHPUnit_Framework_AssertionFailedError
     * @author Hidenori Wasa <public@hidenori-wasa.com>
     */
    static function fail($message = '')
    {
        B::assert(is_string($message));

        try {
            parent::fail($message);
        } catch (\Exception $e) {
            B::exitForError($e); // Displays error call stack information.
        }
    }

}
