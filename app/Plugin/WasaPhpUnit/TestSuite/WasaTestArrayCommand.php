<?php

/**
 * TestRunner for CakePHP Test suite.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @category  DUMMY
 * @package   Cake.TestSuite
 * @author    CakePHP(tm) <dummy@dummy.com>
 * @copyright 2005-2015 Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     CakePHP(tm) v 2.0
 */
\App::uses('CakeTestSuiteCommand', 'TestSuite');
/**
 * Class to customize loading of test suites from CLI
 *
 * @category  DUMMY
 * @package   Cake.TestSuite
 * @author    CakePHP(tm) <dummy@dummy.com>
 * @copyright 2005-2015 Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     CakePHP(tm) v 2.0
 */
class WasaTestArrayCommand extends \CakeTestSuiteCommand
// class CakeTestSuiteCommand extends PHPUnit_TextUI_Command {
{

    /**
     * Ugly hack to get around PHPUnit having a hard coded class name for the Runner. :(
     *
     * @param array   $argv Argument values.
     * @param boolean $exit Is this exits?
     *
     * @return void
     * @author Hidenori Wasa <public@hidenori-wasa.com>
     */
    public function run(array $argv, $exit = true)
    {
        $this->handleArguments($argv);

        // CakePHP's special line.
        $runner = $this->getRunner($this->arguments['loader']);

        $suite = $runner->getTest(
            $this->arguments['test'], $this->arguments['testFile']
        );

        unset($this->arguments['test']);
        unset($this->arguments['testFile']);

        try {
            $result = $runner->doRun($suite, $this->arguments);
        } catch (PHPUnit_Framework_Exception $e) {
            print $e->getMessage() . "\n";
        }

        // if ($exit) {
        //    if (isset($result) && $result->wasSuccessful()) {
        //        exit(PHPUnit_TextUI_TestRunner::SUCCESS_EXIT);
        //    } elseif (!isset($result) || $result->errorCount() > 0) {
        //        exit(PHPUnit_TextUI_TestRunner::EXCEPTION_EXIT);
        //    }
        //    exit(PHPUnit_TextUI_TestRunner::FAILURE_EXIT);
        // }
        $ret = PHPUnit_TextUI_TestRunner::FAILURE_EXIT;

        if (isset($result) && $result->wasSuccessful()) {
            $ret = PHPUnit_TextUI_TestRunner::SUCCESS_EXIT;
        } else if (!isset($result) || $result->errorCount() > 0) {
            $ret = PHPUnit_TextUI_TestRunner::EXCEPTION_EXIT;
        }

        return $ret;
    }

}
