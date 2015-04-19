<?php

/**
 * Wasa's Bootstrap3 Application Controller
 *
 * LICENSE:
 * Copyright (c) 2015-, Hidenori Wasa
 * All rights reserved.
 *
 * License content is written in "app/Plugin/Wasa/WASA_LICENSE.txt".
 *
 * @category DUMMY
 * @package  WasaBootstrap3.Controller
 * @author   Hidenori Wasa <public@hidenori-wasa.com>
 * @license  http://opensource.org/licenses/mit-license.php  MIT License
 * @link     https://github.com/hidenori-wasa/_CakePHP0204Lib/
 */
\App::uses('AppController', 'Controller');
/**
 * Wasa's Bootstrap3 Application Controller
 *
 * CakePHP = 2.4.x
 * Bootstrap = 3.2.0
 *
 * @category DUMMY
 * @package  WasaBootstrap3.Controller
 * @author   Hidenori Wasa <public@hidenori-wasa.com>
 * @license  http://opensource.org/licenses/mit-license.php  MIT License
 * @version  Draft: 1.0.0
 * @link     https://github.com/hidenori-wasa/_CakePHP0204Lib/
 */
class WasaBootstrap3AppController extends AppController
{
    /**
     * Helpers for view.
     *
     * @var array
     */
    public $helpers = array (
        'Form' => array ('className' => 'WasaBootstrap3.WasaForm'), // Uses "WasaForm" helper instead of "Form" helper.
        'Paginator' => array ('className' => 'BoostCake.BoostCakePaginator'), // Uses "BoostCakePaginator" helper instead of "Paginator" helper.
    );

    /**
     * Setting to use "SecurityComponent" class for "CSRF" check.
     *
     * @var array
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

    /**
     * Registers security callback class method.
     *
     * @return void
     */
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
