<?php

/**
 * Wasa's Application Model.
 *
 * LICENSE:
 * Copyright (c) 2015-, Hidenori Wasa
 * All rights reserved.
 *
 * License content is written in "app/Plugin/Wasa/WASA_LICENSE.txt".
 *
 * @category DUMMY
 * @package  Wasa.Model
 * @author   Hidenori Wasa <public@hidenori-wasa.com>
 * @license  http://opensource.org/licenses/mit-license.php  MIT License
 * @link     https://github.com/hidenori-wasa/_CakePHP0204Lib/
 */
\App::uses('AppModel', 'Model');
\App::uses('WasaBootstrap3AppController', 'WasaBootstrap3.Controller');
\App::uses('WasaCache', 'Wasa.Cache');
/**
 * Wasa's Application Model.
 *
 * CakePHP = 2.4.x
 * Bootstrap = 3.2.0
 *
 * @category DUMMY
 * @package  Wasa.Model
 * @author   Hidenori Wasa <public@hidenori-wasa.com>
 * @license  http://opensource.org/licenses/mit-license.php  MIT License
 * @version  Draft: 1.0.0
 * @link     https://github.com/hidenori-wasa/_CakePHP0204Lib/
 */
class WasaAppModel extends \AppModel
{

    /**
     * Sets "$validate" property for model validation.
     */
    function __construct()
    {
        $this->validate = $this->getModelValidation();

        parent::__construct();
    }

    /**
     * Gets the model validation.
     *
     * @return mixed Validation array.
     */
    protected function getModelValidation()
    {
        // Gets controller instance.
        $self = \ClassRegistry::getObject('WasaBootstrap3AppController');
        // If data was posted from form.
        if ($self->request->is('post')) {
            $defaultModel = $self->plugin;
            if (empty($defaultModel)) {
                $defaultModel = $self->modelClass;
            } else {
                $defaultModel .= '.' . $self->modelClass;
            }
            // Returns the model validation.
            return \WasaCache::readArray($defaultModel);
        } else { // If first time.
            return null;
        }
    }

}
