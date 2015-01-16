<?php

/**
 * Simple cache class which doesn't depend on environment.
 *
 * CakePHP = 2.4.x
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
    private static $__request;

    /**
     * Registers a request to static property.
     *
     * @param CakeRequest $request Request from client to server.
     */
    function __construct($request)
    {
        self::$__request = $request;
    }

    /**
     * Adds array to the cache.
     *
     * @param string $key   The cache key.
     * @param mixed  $array A array to add in cache.
     *
     * @return void
     * @throws \CakeException
     */
    static function write($key, $array)
    {
        if (WASA_DEBUG_LEVEL && !is_array($array)) {
            throw new \CakeException('You must set array value to second parameter.');
        }
        $nativeValue = self::read($key);
        $array = $nativeValue + $array;
        if ($array !== $nativeValue) {
            $result = \Cache::write($key, $array, self::SETTING_NAME);
            if (WASA_DEBUG_LEVEL && $result === false) {
                throw new \CakeException('Cache writing failed.');
            }
        }
    }

    /**
     * Reads array from cache.
     *
     * @param string $key The cache key.
     *
     * @return mixed The read array.
     * @throws \CakeException
     */
    static function read($key)
    {
        if (self::$__didSetting === false) {
            self::$__didSetting = true;
            if (WASA_DEBUG_LEVEL && \Configure::read('Cache.disable') === true) {
                throw new \CakeException('You must set "Configure::write(\'Cache.disable\', false);" into "app/Config/core.php".');
            }
            $result = \Cache::config(self::SETTING_NAME, array ('duration' => PHP_INT_MAX, 'engine' => 'File', 'lock' => true, 'prefix' => 'wasa_cake_', 'probability' => 100,));
            if (WASA_DEBUG_LEVEL && $result === false) {
                throw new \CakeException('The cache failed configuration.');
            }
            while (!\Cache::isInitialized(self::SETTING_NAME)) {
                usleep(10000);
            }
            $array = \Cache::read($key, self::SETTING_NAME);
            if ($array === false) {
                if (self::$__request->is('post') || self::$__request->is('put')) {
                    throw new \CakeException('Cache timeouted.');
                } else {
                    $result = \Cache::write($key, array (), self::SETTING_NAME);
                    if (WASA_DEBUG_LEVEL && $result === false) {
                        throw new \CakeException('Cache writing failed.');
                    }
                    return array ();
                }
            }
            return $array;
        }

        $array = \Cache::read($key, self::SETTING_NAME);
        if ($array === false) {
            throw new \CakeException('Cache timeouted.');
        }
        return $array;
    }

}
