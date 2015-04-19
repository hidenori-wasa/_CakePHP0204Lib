/**
 * LICENSE:
 * Copyright (c) 2014-, Hidenori Wasa
 * All rights reserved.
 * @license  http://opensource.org/licenses/mit-license.php  MIT License
 */

/**
 * Setting to display JavaScript error message.
 * <pre>
 *
 * <code>
 * &lt;meta charset="utf-8"&gt;
 * &lt;?php
 * // Loads the "WasaGlobalErrorHandler.js" JavaScript file.
 * echo $this->Html->script('WasaGlobalErrorHandler');
 * echo $this->fetch('script');
 * ?&gt;
 * </code>
 *
 * </pre>
 * @param {string} $message Error message.
 * @param {string} $uri     Error file's URI.
 * @param {string} $line    Error line.
 * @param {string} $col     Error column.
 * @param {object} $error   Error object.
 *
 * @returns {Boolean} true
 */
window.onerror = function ($message, $uri, $line, $col, $error) {
    if ($error) {
        alert('MESSAGE ===> ' + $error.message + '\n' + 'URI ========> ' + $error.fileName + '\n' + 'LINE =======> ' + $error.lineNumber + '\n' + 'COLUMN ====> ' + $error.columnNumber + '\n' + 'STACK =====>' + $error.stack);
    } else {
        alert('MESSAGE ===> ' + $message + '\n' + 'URI ========> ' + $uri + '\n' + 'LINE =======> ' + $line + '\n' + 'COLUMN ====> ' + $col);
    }
    return true;
};
