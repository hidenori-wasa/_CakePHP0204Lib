<?php

/**
 * This file is loaded automatically by the app/webroot/index.php file after core.php
 *
 * This file should load/create any application wide configuration settings, such as
 * Caching, Logging, loading additional configuration files.
 *
 * You should also use this file to include any files that provide global functions/constants
 * that your application uses.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @category  DUMMY
 * @package   Wasa.Config
 * @author    CakePHP(tm) <dummy@dummy.com>
 * @copyright 2005-2015 Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     CakePHP(tm) v 0.10.8.2117
 */
require_once './BreakpointDebugging_Inclusion.php';

if (BREAKPOINTDEBUGGING_IS_PRODUCTION) { // Production mode.
    // Defines debug level automatically.
    \Configure::write('debug', 0);
} else { // Development mode. Or, production mode of unit test emulation.
    // Checks the debug level setting.
    if (\Configure::read('debug') !== 0) {
        throw new \BreakpointDebugging_ErrorException('Debug level must not be set, so "\Configure::write(\'debug\',..." must be commented out in "app/Config/core.php".');
    }
    // Defines debug level automatically.
    \Configure::write('debug', 2);
    // Checks "CakeLog" class setting.
    if (\CakeLog::configured() !== array ()) {
        throw new \BreakpointDebugging_ErrorException('"CakeLog" class configuration must not exist, so "CakeLog::config()" must be commented out in "app/Config/bootstrap.php".');
    }
    // Checks the fact that error handler is not defined because it is defined inside "BreakpointDebugging" pear package.
    if (\Configure::read('Error') !== array ('handler' => 'ErrorHandler::handleError', 'level' => -1, 'trace' => true)) {
        throw new \BreakpointDebugging_ErrorException('Error handler must be defined by "\Configure::write(\'Error\', array (\'handler\' => \'ErrorHandler::handleError\', \'level\' => -1, \'trace\' => true));" in "app/Config/core.php".');
    }
    // Checks the fact that exception handler is not defined because it is defined inside "BreakpointDebugging" pear package.
    if (\Configure::read('Exception') !== array ('handler' => '\BreakpointDebugging_InAllCase::handleException')) {
        throw new \BreakpointDebugging_ErrorException('Exception handler must be defined by "\Configure::write(\'Exception\', array (\'handler\' => \'\BreakpointDebugging_InAllCase::handleException\'));" in "app/Config/core.php".');
    }
}
