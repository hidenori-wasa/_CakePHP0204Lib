<?php

/**
 * "\WasaTestArrayDispatcher" class controls dispatching of test file paths array.
 *
 * CakePHP(tm) Tests <http://book.cakephp.org/2.0/en/development/testing.html>
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice
 *
 * @category  DUMMY
 * @package   Cake.TestSuite
 * @author    CakePHP(tm) <dummy@dummy.com>
 * @copyright 2005-2015 Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     CakePHP(tm) v 1.3
 */
\App::uses('CakeTestSuiteDispatcher', 'TestSuite');
\App::uses('WasaTestArrayCommand', 'WasaPhpUnit.TestSuite');
/**
 * "\WasaTestArrayDispatcher" class controls dispatching of test file paths array.
 *
 * @category  DUMMY
 * @package   Cake.TestSuite
 * @author    CakePHP(tm) <dummy@dummy.com>
 * @copyright 2005-2015 Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     CakePHP(tm) v 1.3
 */
class WasaTestArrayDispatcher extends \CakeTestSuiteDispatcher
{
    private static $__dispatcher;

    /**
     * Prepares to dispatch test.
     *
     * @return void
     * @author Hidenori Wasa <public@hidenori-wasa.com>
     */
    public function dispatch()
    {
        $this->_parseParams();
        self::$__dispatcher = $this;
        return;

        // $this->_checkPHPUnit();
        // $this->_parseParams();
        //
        // if ($this->params['case']) {
        //     $value = $this->_runTestCase();
        // } else {
        //     $value = $this->_testCaseList();
        // }
        //
        // $output = ob_get_clean();
        // echo $output;
        // return $value;
    }

    /**
     * Initializes the test runner, and keeps the global space clean.
     *
     * @return void
     * @author Hidenori Wasa <public@hidenori-wasa.com>
     */
    public static function run()
    {
        $dispatcher = new \WasaTestArrayDispatcher();
        $dispatcher->dispatch();
    }

    /**
     * Calls class method for "phpunit" command running.
     *
     * @param type $commandElements The command elements.
     *
     * @return void
     * @author Hidenori Wasa <public@hidenori-wasa.com>
     */
    static function runPHPUnitCommand($commandElements)
    {
        self::$__dispatcher->runTestCase2($commandElements);
    }

    /**
     * Runs "phpunit" command by parameter customization.
     *
     * @param type $commandElements The command elements.
     *
     * @return void
     * @author Hidenori Wasa <public@hidenori-wasa.com>
     */
    protected function runTestCase2($commandElements)
    {
        $commandArgs = array (
            // 'case' => $this->params['case'],
            'case' => null,
            // 'core' => $this->params['core'],
            // 'app' => $this->params['app'],
            // 'plugin' => $this->params['plugin'],
            // 'codeCoverage' => $this->params['codeCoverage'],
            // 'showPasses' => !empty($this->params['show_passes']),
            'baseUrl' => $this->_baseUrl,
            'baseDir' => $this->_baseDir,
        );

        $options = array (
            '--filter', $this->params['filter'],
            // '--output', $this->params['output'],
            '--fixture', $this->params['fixture']
        );
        array_shift($commandElements);
        array_shift($commandElements);
        $commandElements = array_merge($options, $commandElements);
        array_unshift($commandElements, '');
        array_unshift($commandElements, 'dummy');
        restore_error_handler();

        try {
            self::time();
            // $command = new CakeTestSuiteCommand('CakeTestLoader', $commandArgs);
            $command = new \WasaTestArrayCommand('PHPUnit_Runner_StandardTestSuiteLoader', $commandArgs);
            // $command->run($options);
            $command->run($commandElements, false);
        } catch (MissingConnectionException $exception) {
            ob_end_clean();
            $baseDir = $this->_baseDir;
            include CAKE . 'TestSuite' . DS . 'templates' . DS . 'missing_connection.php';
            exit();
        }
    }

}
