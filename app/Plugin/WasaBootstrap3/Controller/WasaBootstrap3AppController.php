<?php

/**
 * Wasa's Bootstrap3 Application Controller
 *
 * CakePHP = 2.4.x
 * Bootstrap = 3.2.0
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
\App::uses('AppController', 'Controller');
/**
 * Wasa's Bootstrap3 Application Controller
 *
 * @category DUMMY
 * @package  DUMMY
 * @author   Hidenori Wasa <public@hidenori-wasa.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD 2-Clause
 * @version  Draft: 1.0.0
 * @link     https://github.com/hidenori-wasa/_CakePHP0204Lib/
 */
class WasaBootstrap3AppController extends AppController
{
    /**
     * @var array Helpers for view.
     */
    public $helpers = array (
        'Form' => array ('className' => 'WasaBootstrap3.WasaForm'), // Uses "WasaForm" helper instead of "Form" helper.
        'Paginator' => array ('className' => 'BoostCake.BoostCakePaginator'), // Uses "BoostCakePaginator" helper instead of "Paginator" helper.
    );

    /**
     * @var array Setting to use "SecurityComponent" class for "CSRF" check.
     */
    public $components = array (
        'Security' => array (
        // 'csrfCheck' => true, // Default value which means validity "CSRF" check.
        // 'csrfExpires' => '+30 minutes', // Default value which "CSRF"-check expires.
        // 'csrfUseOnce' => true, // Default value which generates new tokens on each request.
        // 'csrfLimit' => 100, // Default value which sets the token number per user to limit session file size.
        // 'unlockedActions' => array (), // The default actions which except "CSRF" and "POST" validation checks.
        // 'validatePost' => true, // Default value which validates the "POST" data validation.
        ),
    );

    /**
     * Constructs instance.
     *
     * @param CakeRequest  $request  Request from client to server.
     * @param CakeResponse $response Response from server to client.
     */
    function __construct($request = null, $response = null)
    {
        parent::__construct($request, $response);

        // Registers controller instance.
        \ClassRegistry::addObject(__CLASS__, $this);
    }

    function beforeFilter()
    {
        parent::beforeFilter();

        // Sets class method name to call when security error is caused.
        // This class method name must avoid the call as action by prefixing "_".
        $this->Security->blackHoleCallback = '_blackhole';
    }

    /**
     * Processes security error.
     *
     * @param string $type Error method type.
     *
     * @return void
     * @throws \BreakpointDebugging_ErrorException
     */
    function _blackhole($type)
    {
        $suffix = $this->name . 'Controller::' . $this->action . '()".';
        switch ($type) {
            case 'Post':
                \CakeSession::write('securityErrorMessage', '"POST" method is denied in "' . $suffix);
                break;
            case 'Get':
                \CakeSession::write('securityErrorMessage', '"GET" method is denied in "' . $suffix);
                break;
            case 'Put':
                \CakeSession::write('securityErrorMessage', '"PUT" method is denied in "' . $suffix);
                break;
            case 'Delete':
                \CakeSession::write('securityErrorMessage', '"DELETE" method is denied in "' . $suffix);
                break;
            case 'secure':
                \CakeSession::write('securityErrorMessage', 'Request must use "HTTPS" protocol in "' . $suffix);
                break;
            case 'auth':
                \CakeSession::write('securityErrorMessage', 'Token error of authentication was caused in "' . $suffix);
                break;
            case 'csrf':
                \CakeSession::write('securityErrorMessage', 'Cross site request forgeries was refused in "' . $suffix);
                break;
            default:
                throw new \BreakpointDebugging_ErrorException('Unknown security error type.');
        }
        $this->redirect(array ('action' => 'displaySecurityError'));
    }

    /**
     * Displays security error.
     *
     * @return void
     */
    function displaySecurityError()
    {

    }

    /**
     * This posts from form.
     *
     * @param object $model          Model instance.
     * @param array  $successMessage Success message key and value.
     *
     * @return void
     */
    function postFromForm($model, $successMessage)
    {
        foreach ($successMessage as $key => $value) {
            if ($this->request->is('post')) {
                $model->create(false);
                if ($model->save($this->request->data[$model->alias])) {
                    \CakeSession::write($key, $value);
                    return;
                }
            }
            if (\CakeSession::read($key) !== null) {
                \CakeSession::delete($key);
            }
            break;
        }
    }

}
