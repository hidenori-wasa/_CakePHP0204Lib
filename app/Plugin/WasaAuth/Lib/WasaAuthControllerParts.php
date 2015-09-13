<?php

/**
 * Statical class to call from controller which uses "Auth" component.
 *
 * LICENSE:
 * Copyright (c) 2015-, Hidenori Wasa
 * All rights reserved.
 *
 * License content is written in "app/Plugin/Wasa/WASA_LICENSE.txt".
 *
 * @category DUMMY
 * @package  WasaAuth.Lib
 * @author   Hidenori Wasa <public@hidenori-wasa.com>
 * @license  http://opensource.org/licenses/mit-license.php  MIT License
 * @link     https://github.com/hidenori-wasa/_CakePHP0204Lib/
 */
/**
 * Statical class to call from controller which uses "Auth" component.
 *
 * CakePHP = 2.4.x
 *
 * @category DUMMY
 * @package  WasaAuth.Lib
 * @author   Hidenori Wasa <public@hidenori-wasa.com>
 * @license  http://opensource.org/licenses/mit-license.php  MIT License
 * @version  Draft: 1.0.0
 * @link     https://github.com/hidenori-wasa/_CakePHP0204Lib/
 */
final class WasaAuthControllerParts
{

    /**
     * For "__construct()".
     *
     * @param array $param Association array which has parameter names as keys.
     *
     * @return void
     * @link   http://localhost/_WasaManual/CakePHP0204.html#WasaAuthControllerParts-construct
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
     * @link   http://localhost/_WasaManual/CakePHP0204.html#WasaAuthControllerParts-login
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
     * @link   http://localhost/_WasaManual/CakePHP0204.html#WasaAuthControllerParts-logout
     */
    static function logout($param)
    {
        extract($param);
        // Goes to action which registered with 'logoutRedirect' key.
        $controller->redirect($controller->Auth->logout());
    }

}
