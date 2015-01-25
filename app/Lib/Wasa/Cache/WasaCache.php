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
/**
 * Simple cache class which doesn't depend on environment.
 *
 * Example:
 * <pre>
 *
 * <code>
 *      // Adds the array to the array buffer.
 *      WC::addArray('CacheKey', $array1);
 *      WC::addArray('CacheKey', $array2);
 *          .
 *          .
 *          .
 *      // Writes the array to cache only once.
 *      \WasaCache::writeArray('CacheKey');
 *      // Reads array from cache.
 *      $readArray = \WasaCache::readArray('CacheKey');
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
    const SETTING_NAME = 'wasa';

    /**
     * @var array The array buffer.
     */
    private static $__arrayBuffer = array ();

    /**
     * @var bool Did setting?
     */
    private static $__didSetting = false;

    /**
     * @var bool Was cache cleared?
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
            if (WASA_DEBUG_LEVEL && \Configure::read('Cache.disable') === true) {
                throw new \CakeException('"Configure::write(\'Cache.disable\', false);" must be set into "app/Config/core.php".');
            }
            // Configures the cache.
            // "'duration' => PHP_INT_MAX" does not expire even though current time will be 2048.
            // "'probability' => 0" because garbage collection is not necessary at configuration.
            //$result = \Cache::config(self::SETTING_NAME, array ('duration' => PHP_INT_MAX, 'engine' => 'File', 'lock' => false, 'prefix' => 'wasa_', 'probability' => 100,));
            $result = \Cache::config(self::SETTING_NAME, array ('duration' => PHP_INT_MAX, 'engine' => 'File', 'lock' => false, 'prefix' => 'wasa_', 'probability' => 0,));
            if (WASA_DEBUG_LEVEL && $result === false) {
                throw new \CakeException('The cache configuration failed.');
            }
            // Checks initialization of the cache configuration.
            if (WASA_DEBUG_LEVEL && !\Cache::isInitialized(self::SETTING_NAME)) {
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
     * @throws \CakeException
     */
    static function readArray($key)
    {
        // Sets the configuration.
        self::_setConfiguration();
        // Reads the cache without shared lock because writing has been ended.
        $cacheArray = \Cache::read($key, self::SETTING_NAME);
        // If cache does not exist.
        if (WASA_DEBUG_LEVEL && $cacheArray === false) {
            throw new \CakeException('"\WasaCache::readArray()" must not be executed before "\WasaCache::writeArray()" execution.');
        }
        return $cacheArray;
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
        if (WASA_DEBUG_LEVEL) {
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
        }
        // If debug.
        if (WASA_DEBUG_LEVEL) {
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
        if (WASA_DEBUG_LEVEL && $array === $arrayBuffer) {
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
        // Sets the configuration.
        self::_setConfiguration();
        // Reads the cache without shared lock because writing is skipped or same value is overwritten.
        $cacheArray = \Cache::read($key, self::SETTING_NAME);
        // If the cache exists.
        if ($cacheArray !== false) {
            if (WASA_DEBUG_LEVEL) { // If debug.
                // The cache existing is mistake because the cache has been cleared.
                throw new \CakeException('"\WasaCache::writeArray()" must be executed only once.');
            } else { // If release.
                // Cancels the writing.
                return;
            }
        }
        // Locks the cache. (Here accesses hard disk.)
        \Cache::set(array ('lock' => true), self::SETTING_NAME);
        try {
            // Writes the array buffer to cache only once. (Here accesses hard disk.)
            $result = \Cache::write($key, self::$__arrayBuffer[$key], self::SETTING_NAME);
        } catch (\Exception $e) {
            // Unlocks the cache. (Here accesses hard disk.)
            \Cache::set(array ('lock' => false), self::SETTING_NAME);
            throw $e;
        }
        // Unlocks the cache. (Here accesses hard disk.)
        \Cache::set(array ('lock' => false), self::SETTING_NAME);
        // Checks error.
        if (WASA_DEBUG_LEVEL && $result === false) {
            throw new \CakeException('Cache writing failed.');
        }
    }

}
