<?php

/**
 * Simple cache class which doesn't depend on environment.
 *
 * Requirement:
 *      CakePHP = 2.4.x
 *
 * LICENSE OVERVIEW:
 * 1. Do not change license text.
 * 2. Copyrighters do not take responsibility for this file code.
 *
 * LICENSE:
 * Copyright (c) 2015, Hidenori Wasa
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 * Redistributions of source code must retain the above copyright notice,
 * this list of conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice,
 * this list of conditions and the following disclaimer
 * in the documentation and/or other materials provided with the distribution.
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO,
 * THE IMPLIED WARRANTIES OF MERCHANTABILITY
 * AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
 * IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT,
 * INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
 * OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE,
 * EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * @category DUMMY
 * @package  DUMMY
 * @author   Hidenori Wasa <public@hidenori-wasa.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD 2-Clause
 * @link     https://github.com/hidenori-wasa/_CakePHP0204Lib/
 */
use BreakpointDebugging as B;

/**
 * Simple cache class which doesn't depend on environment.
 *
 * <pre>
 * Sample code:
 *
 * <code>
 *      // Reads array from cache.
 *      $readArray = \WasaCache::readArray('CacheKey');
 *      if ($readArray === null) {
 *          // Some code.
 *          $array1 = array('Something value 1.');
 *          // Adds the array to the array buffer.
 *          \WasaCache::addArray('CacheKey', $array1);
 *          // Some code.
 *          $array2 = array('Something value 2.');
 *          // Adds the array to the array buffer.
 *          \WasaCache::addArray('CacheKey', $array2);
 *          // Writes the array to cache only once.
 *          \WasaCache::writeArray('CacheKey');
 *          // Reads array from cache.
 *          $readArray = \WasaCache::readArray('CacheKey');
 *      }
 * </code>
 *
 * </pre>
 *
 * @category DUMMY
 * @package  DUMMY
 * @author   Hidenori Wasa <public@hidenori-wasa.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD 2-Clause
 * @version  Draft: 1.0.0
 * @link     https://github.com/hidenori-wasa/_CakePHP0204Lib/
 */
class WasaCache
{
    /**
     * The cache configuration setting name.
     * @const string
     */
    const SETTING_NAME = 'wasa';

    /**
     * The array buffer.
     * @var array
     */
    private static $__arrayBuffer = array ();

    /**
     * Did setting?
     * @var bool
     */
    private static $__didSetting = false;

    /**
     * Was cache cleared?
     * @var bool
     */
    private static $__wasCacheCleared = false;

    /**
     * Sets the configuration.
     *
     * @return void
     * @throws \CakeException
     */
    private static function _setConfiguration()
    {
        // If first time after request.
        if (self::$__didSetting === false) {
            self::$__didSetting = true;
            // Checks the cache setting.
            if (B::isDebug() && \Configure::read('Cache.disable') === true) {
                throw new \CakeException('"Configure::write(\'Cache.disable\', false);" must be set into "app/Config/core.php".');
            }
            // Configures the cache.
            // "'duration' => PHP_INT_MAX" does not expire even though current time will be 2048.
            // "'probability' => 0" because garbage collection is not necessary at configuration.
            $result = \Cache::config(self::SETTING_NAME, array ('duration' => PHP_INT_MAX, 'engine' => 'File', 'lock' => false, 'prefix' => 'wasa_', 'probability' => 0,));
            if (B::isDebug() && $result === false) {
                throw new \CakeException('The cache configuration failed.');
            }
            // Checks initialization of the cache configuration.
            if (B::isDebug() && !\Cache::isInitialized(self::SETTING_NAME)) {
                throw new \CakeException('The cache configuration has not been initialized.');
            }
        }
    }

    /**
     * Reads array from cache.
     *
     * @param string $key The cache key.
     *
     * @return array The read array.
     */
    static function readArray($key)
    {
        // Sets the configuration.
        self::_setConfiguration();
        // Reads the cache without shared lock for no disk access.
        // (Here may cause hard disk accesses. But, it will be read from OS system file cache almost.)
        // Ignores error and exception because writing may be executed during reading.
        set_error_handler('\BreakpointDebugging::handleError', 0);
        for ($count = 0; $count < 20; $count++) {
            try {
                $cacheArray = @\Cache::read($key, self::SETTING_NAME);
            } catch (\Exception $e) {
                $exception = $e;
                // Waits for hard disc writing.
                sleep(1);
                continue;
            }
            restore_error_handler();
            // If cache does not exist or read error.
            if ($cacheArray === false) {
                return null;
            }
            // Pops up the expected array element number.
            $expectedArrayElementNumber = array_pop($cacheArray);
            // Checks reading because writing may be executed during reading.
            if ($expectedArrayElementNumber !== array ('WasaCacheCheck' => count($cacheArray))) {
                // Waits for hard disc writing.
                sleep(1);
                continue;
            }
            return $cacheArray;
        }
        // If exception has been occurred.
        if (isset($exception)) {
            throw new $exception;
        }
        // If the reading data is incorrect.
        throw new \BreakpointDebugging_ErrorException('The reading data is incorrect.', 101);
    }

    /**
     * Adds the array to the array buffer.
     *
     * @param string $key   The cache key.
     * @param array  $array A array to add in cache.
     *
     * @return void
     * @throws \CakeException
     */
    static function addArray($key, $array)
    {
        // Sets the configuration.
        self::_setConfiguration();
        // If debug.
        if (B::isDebug()) {
            // Checks the value type to write.
            if (!is_array($array)) {
                throw new \CakeException('Second parameter must be set array value.');
            }
            // If first time after request.
            if (self::$__wasCacheCleared === false) {
                self::$__wasCacheCleared = true;
                // Clears cache for debug.
                if (\Cache::clear(false, self::SETTING_NAME) !== false) {
                    \Cache::gc(self::SETTING_NAME);
                }
            }
            // If the cache exists.
            if (\Cache::read($key, self::SETTING_NAME) !== false) {
                throw new \CakeException('"\WasaCache::addArray()" must not be executed after "\WasaCache::writeArray()".');
            }
        }
        // If the cache key is first time addition.
        if (!array_key_exists($key, self::$__arrayBuffer)) {
            self::$__arrayBuffer[$key] = array ();
        }
        $arrayBuffer = &self::$__arrayBuffer[$key];
        // Merges the array buffer and the array.
        $array = $arrayBuffer + $array;
        // If this is same value in case of debug.
        if (B::isDebug() && $array === $arrayBuffer) {
            throw new \CakeException('Same value must not be added.');
        }
        // Adds the array to the array buffer.
        $arrayBuffer = $array;
    }

    /**
     * Writes the array buffer to cache only once.
     *
     * @param string $key The cache key.
     *
     * @return void
     */
    static function writeArray($key)
    {
        $cacheArray = self::readArray($key);
        // If the cache exists.
        if ($cacheArray !== null) {
            if (B::isDebug()) { // If debug.
                // The cache existing is mistake because the cache has been cleared.
                throw new \CakeException('"\WasaCache::writeArray()" must be executed only once.');
            } else { // If release.
                // Cancels the writing.
                return;
            }
        }
        // Changes the cache setting to locking.
        \Cache::set(array ('lock' => true), self::SETTING_NAME);
        try {
            // Pushes the expected array element number.
            array_push(self::$__arrayBuffer[$key], array ('WasaCacheCheck' => count(self::$__arrayBuffer[$key])));
            // Writes the array buffer to cache only once. (Here causes hard disk accesses in locking, writing and unlocking.)
            $result = \Cache::write($key, self::$__arrayBuffer[$key], self::SETTING_NAME);
            unset(self::$__arrayBuffer[$key]);
        } catch (\Exception $e) {
            // Changes the cache setting to unlocking.
            \Cache::set(array ('lock' => false), self::SETTING_NAME);
            throw $e;
        }
        // Changes the cache setting to unlocking.
        \Cache::set(array ('lock' => false), self::SETTING_NAME);
        // Checks error.
        if (B::isDebug() && $result === false) {
            throw new \CakeException('Cache writing failed.');
        }
    }

}
