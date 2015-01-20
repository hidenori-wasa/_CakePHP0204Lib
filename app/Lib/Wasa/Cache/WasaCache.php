<?php

/**
 * Simple cache class which doesn't depend on environment.
 *
 * Requirement:
 *      CakePHP = 2.4.x
 *
 * example:
 *      // Adds array to the cache.
 *      WC::write('CacheKey', $array1);
 *      WC::write('CacheKey', $array2);
 *          .
 *          .
 *          .
 *      // Ends the cache writing.
 *      \WasaCache::endWriting('CacheKey');
 *      // Reads array from cache.
 *      $readArray = \WasaCache::read('CacheKey');
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

    private static $__didSetting = false;
    private static $__didWrite = false;

    /**
     * Sets the configuration.
     *
     * @return void
     * @throws \CakeException
     */
    private static function __setConfiguration()
    {
        // If first time after request.
        if (self::$__didSetting === false) {
            self::$__didSetting = true;
            // Checks the cache setting.
            if (WASA_DEBUG_LEVEL && \Configure::read('Cache.disable') === true) {
                throw new \CakeException('You must set "Configure::write(\'Cache.disable\', false);" into "app/Config/core.php".');
            }
            // Configures the cache.
            $result = \Cache::config(self::SETTING_NAME, array ('duration' => PHP_INT_MAX, 'engine' => 'File', 'lock' => false, 'prefix' => 'wasa_', 'probability' => 100,));
            if (WASA_DEBUG_LEVEL && $result === false) {
                throw new \CakeException('The cache configuration failed.');
            }
            // Waits until cache initialization.
            while (!\Cache::isInitialized(self::SETTING_NAME)) {
                usleep(10000);
            }
        }
    }

    /**
     * Reads array from cache.
     *
     * @param string $key The cache key.
     *
     * @return array The read array.
     * @//throws \CakeException
     */
    private static function __read($key)
    {
        // Reads the cache without lock.
        $array = \Cache::read($key, self::SETTING_NAME);
        // If this is not array.
        if (!\is_array($array)) {
            // Returns an empty array.
            return array ();
        }
        return $array;
    }

    /**
     * Reads array from cache.
     *
     * @param string $key The cache key.
     *
     * @return array The read array.
     * @throws \CakeException
     */
    static function read($key)
    {
        // Sets the configuration.
        self::__setConfiguration();
        // Reads the cache without lock.
        $array = self::__read($key);
        // Checks the writing end flag.
        if (WASA_DEBUG_LEVEL && !array_key_exists('WasaCacheDidAllWriting', $array)) {
            throw new \CakeException('You must write all data before read.');
        }
        return $array;
    }

    /**
     * Adds array to the cache.
     *
     * @param string $key         The cache key.
     * @param array  $nativeArray Native array.
     * @param array  $array       A array to add in cache.
     *
     * @return void
     * @throws \CakeException
     */
    private static function __write($key, $nativeArray, $array)
    {
        // New array value overwrites for writing during reading.
        $array = $nativeArray + $array;
        // If the cache value is changed because other process may write same value.
        if ($array !== $nativeArray) {
            // Locks the cache.
            \Cache::set(array ('lock' => true), self::SETTING_NAME);
            // Writes to the cache.
            $result = \Cache::write($key, $array, self::SETTING_NAME);
            // Unlocks the cache.
            \Cache::set(array ('lock' => false), self::SETTING_NAME);
            if (WASA_DEBUG_LEVEL && $result === false) {
                throw new \CakeException('Cache writing failed.');
            }
        } else if (WASA_DEBUG_LEVEL) { // If debug.
            throw new \CakeException('You must not write same value.');
        }
    }

    /**
     * Adds array to the cache.
     *
     * @param string $key   The cache key.
     * @param array  $array A array to add in cache.
     *
     * @return void
     * @throws \CakeException
     */
    static function write($key, $array)
    {
        // Sets the configuration.
        self::__setConfiguration();
        // If debug.
        if (WASA_DEBUG_LEVEL) {
            // Checks the value type to write.
            if (!is_array($array)) {
                throw new \CakeException('You must set array value to second parameter.');
            }
            // If first time after request.
            if (self::$__didWrite === false) {
                self::$__didWrite = true;
                // Clears cache for debug.
                if (\Cache::clear(false, self::SETTING_NAME) !== false) {
                    \Cache::gc(self::SETTING_NAME);
                }
            }
        }
        // Reads native array.
        $nativeArray = self::__read($key);
        // If "WasaCache" did all writing.
        if (array_key_exists('WasaCacheDidAllWriting', $array)) {
            return;
        }
        // Adds array to the cache.
        self::__write($key, $nativeArray, $array);
    }

    /**
     * End writing.
     *
     * @param string $key The cache key.
     *
     * @return void
     */
    static function endWriting($key)
    {
        // Sets the configuration.
        self::__setConfiguration();
        $nativeArray = self::__read($key);
        // If "WasaCache" did all writing.
        if (array_key_exists('WasaCacheDidAllWriting', $nativeArray)) {
            return;
        }
        // Writes the writing end flag.
        self::__write($key, $nativeArray, array ('WasaCacheDidAllWriting' => true));
    }

}
