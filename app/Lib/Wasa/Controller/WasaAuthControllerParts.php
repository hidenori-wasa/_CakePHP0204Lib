<?php

/**
 * Statical class to call from controller which uses "Auth" component.
 *
 * CakePHP = 2.4.x
 *
 * LICENSE OVERVIEW:
 * 1. Do not change license text.
 * 2. Copyrighters do not take responsibility for this file code.
 *
 * LICENSE:
 * Copyright (c) 2014, Hidenori Wasa
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
 * Statical class to call from controller which uses "Auth" component.
 *
 * @category DUMMY
 * @package  DUMMY
 * @author   Hidenori Wasa <public@hidenori-wasa.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD 2-Clause
 * @version  Draft: 1.0.0
 * @link     https://github.com/hidenori-wasa/_CakePHP0204Lib/
 */
final class WasaAuthControllerParts
{

    /**
     * __construct 用
     *
     * @param array $param Association array which has parameter names as keys.
     *
     * @return void
     * @link http://localhost/_WasaManual/index.php#WasaAuthControllerParts-construct
     */
    static function construct($param)
    {
        extract($param);
        // Model name to use.
        $controller->uses = array ($authModelName);
        // Components names to use.
        $controller->components = array (
            // Authentication component.
            'Auth' => array (
                // Authentication way.
                'authenticate' => array (
                    // "Blowfish" authentication.
                    'Blowfish' => array ('userModel' => $authModelName),
                ),
                // Error message in case of page which needs login.
                'authError' => $authErrorMessageOfDeniedPage,
                // Login action.
                'loginAction' => array (
                    'controller' => \Inflector::pluralize($authModelName), // Default: 'Users'
                    'action' => 'login',
                    'plugin' => null
                ),
                // Action after login.
                'loginRedirect' => $loginRedirectAction,
                // Action after logout.
                'logoutRedirect' => $logoutRedirectAction,
            ),
            // This component is needed because it uses in login message and so on.
            'Session',
        );
    }

    /**
     * Login action.
     *
     * @param array $param Association array which has parameter names as keys.
     *
     * @return void
     * @link http://localhost/_WasaManual/index.php#WasaAuthControllerParts-login
     */
    static function login($param)
    {
        extract($param);
        // If request is post.
        if ($controller->request->is('post')) {
            // If customer succeeded login.
            if ($controller->Auth->login()) {
                // Goes to action which registered with 'loginRedirect' key.
                $controller->redirect($controller->Auth->redirectUrl());
            }
            // Displays error if customer failed login.
            $controller->Auth->flash($loginFailureMessage);
        }
    }

    /**
     * The logout action.
     *
     * @param array $param Association array which has parameter names as keys.
     *
     * @return void
     * @link http://localhost/_WasaManual/index.php#WasaAuthControllerParts-logout
     */
    static function logout($param)
    {
        extract($param);
        // Goes to action which registered with 'logoutRedirect' key.
        $controller->redirect($controller->Auth->logout());
    }

}
