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
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
if (!class_exists('WasaErrorException', false)) {
    if (defined('BREAKPOINTDEBUGGING_IS_CAKE')) { // If "BreakpointDebugging" pear package exists.
        class WasaErrorException extends \BreakpointDebugging_ErrorException
        {
            
        }

        if (!BREAKPOINTDEBUGGING_IS_PRODUCTION) { // In case of development server mode.
            // Checks the fact that error handler is not defined because it is defined inside "BreakpointDebugging" pear package.
            if (\Configure::read('Error') !== null) {
                throw new \WasaErrorException('You must define error handler by "\Configure::write(array (\'Error\' => null));" inside "app/Config/core.php".');
            }
            // Checks the fact that exception handler is not defined because it is defined inside "BreakpointDebugging" pear package.
            if (\Configure::read('Exception') !== null) {
                throw new \WasaErrorException('You must define exception handler by "\Configure::write(array (\'Exception\' => null));" inside "app/Config/core.php".');
            }
        }
    } else { // If default.
        class WasaErrorException extends \CakeException
        {

        }

        $wasaResult = \Configure::read('debug');
        // Checks the fact that debug level is defined.
        if ($wasaResult === null) {
            throw new \WasaErrorException('You must define debug level by "\Configure::write(\'debug\', ..." inside "app/Config/core.php".');
        }
        if ($wasaResult > 0) {
            // Checks the fact that error handler is defined.
            if (\Configure::read('Error') === null) {
                throw new \WasaErrorException('You must define error handler by "\Configure::write(array (\'Error\' => ..." inside "app/Config/core.php".');
            }
            // Checks the fact that exception handler is defined.
            if (\Configure::read('Exception') === null) {
                throw new \WasaErrorException('You must define exception handler by "\Configure::write(array (\'Exception\' => ..." inside "app/Config/core.php".');
            }
        }
    }
    unset($wasaResult);
}
