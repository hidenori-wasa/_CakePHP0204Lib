<?php

// >
// Changes current directory to web root.
chdir('../../../../../');

require_once './BreakpointDebugging_Inclusion.php';

use \BreakpointDebugging as B;

B::checkExeMode(true);

function BreakpointDebugging_test()
{
    $breakpointDebugging_PHPUnit = new \BreakpointDebugging_PHPUnit();
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Please, choose unit tests files by customizing.
    $breakpointDebugging_UnitTestFiles = array (
        /*
         */
        'Sub/ExampleTest.php',
        'RuleTest.php',
        /*
         */
    );

    // Specifies the test directory if "CakePHP".
    // $breakpointDebugging_PHPUnit->setTestDir('../../Plugin/WasaPhpUnit/Test/Case/');
    //
    // Executes unit tests.
    $breakpointDebugging_PHPUnit->executeUnitTest($breakpointDebugging_UnitTestFiles); exit;

    // Makes up code coverage report, then displays in browser.
    $breakpointDebugging_PHPUnit->displayCodeCoverageReport('Sub/ExampleTest.php', 'Sub/Example.php'); exit;
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Please, choose simple unit tests files by customizing.
    $breakpointDebugging_UnitTestFiles = array (
        /*
         */
        'Sub/ExampleTestSimple.php',
        'RuleTestSimple.php',
        /*
         */
    );

    // Executes simple unit tests.
    $breakpointDebugging_PHPUnit->executeUnitTestSimple($breakpointDebugging_UnitTestFiles); exit;

    // Makes up code coverage report, then displays in browser.
    $breakpointDebugging_PHPUnit->displayCodeCoverageReport('Sub/ExampleTestSimple.php', 'Sub/Example.php', 'SIMPLE'); exit;
}

BreakpointDebugging_test();
