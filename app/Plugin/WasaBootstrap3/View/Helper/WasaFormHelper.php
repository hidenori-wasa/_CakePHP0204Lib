<?php

/**
 * Customized form helper.
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
\App::uses('FormHelper', 'View/Helper');
\App::uses('WasaBootstrap3FormHelper', 'WasaBootstrap3.View/Helper');
/**
 * Customized form helper.
 *
 * @category DUMMY
 * @package  DUMMY
 * @author   Hidenori Wasa <public@hidenori-wasa.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD 2-Clause
 * @version  Draft: 1.0.0
 * @link     https://github.com/hidenori-wasa/_CakePHP0204Lib/
 */
final class WasaFormHelper extends \FormHelper
{

    /**
     * Sets the debug's level.
     *
     * @param View  $View     Same as parent.
     * @param array $settings Same as parent.
     */
    public function __construct(View $View, $settings = array ())
    {
        \WasaBootstrap3FormHelper::construct($this);

        parent::__construct($View, $settings);
    }

    /**
     * Gets model name.
     *
     * @return string The model name.
     * @throws \CakeException
     */
    function getModelName()
    {
        $modelName = $this->defaultModel;
        // If this form does not use model.
        if ($modelName === null) {
            throw new \CakeException('You must use model.');
        }
        return $modelName;
    }

    /**
     * Checks the schema of field.
     *
     * @param string $fieldName            Field name to check.
     * @param string $expectedFieldType    Expected field type.
     * @param int    $expectedByteSize     Expected byte size.
     * @param bool   $doesNullAllow        Does null allow?
     * @param mixed  $expectedDefaultValue Expected default value.
     * @param string $expectedKeyType      Expected key type. (PRI | UNI | MUL)
     * @param type   $expectedExtra        Expected extra information. (AUTO_INCREMENT)
     *
     * @return void
     * @throws \CakeException
     */
    function checkSchema($fieldName, $expectedFieldType, $expectedByteSize = null, $doesNullAllow = null, $expectedDefaultValue = null, $expectedKeyType = null, $expectedExtra = null)
    {
        $modelName = $this->defaultModel;
        if (!\BreakpointDebugging::isDebug() // If release.
            || $modelName === null // If this form does not use model.
        ) {
            return;
        }
        $model = $this->_getModel($modelName);
        $fieldSchema = $model->schema($fieldName);
        $errorMessagePrefix = $modelName . '.' . $fieldName . ' field must be that ';
        if ($fieldSchema['type'] !== $expectedFieldType) {
            throw new \CakeException($errorMessagePrefix . $expectedFieldType . ' type.');
        }
        if ($doesNullAllow !== null //
            && $fieldSchema['null'] !== $doesNullAllow //
        ) {
            throw new \CakeException($errorMessagePrefix . 'null allowing is ' . (string) $doesNullAllow . '.');
        }
        if ($expectedDefaultValue !== null //
            && $fieldSchema['default'] !== $expectedDefaultValue //
        ) {
            throw new \CakeException($errorMessagePrefix . 'default value is ' . $expectedDefaultValue . '.');
        }
        if ($expectedKeyType !== null //
            && $fieldSchema['key'] !== $expectedKeyType //
        ) {
            throw new \CakeException($errorMessagePrefix . 'key type is ' . $expectedKeyType . '.');
        }
        if ($expectedByteSize !== null //
            && $fieldSchema['length'] !== $expectedByteSize //
        ) {
            throw new \CakeException($errorMessagePrefix . 'byte size is ' . $expectedByteSize . '.');
        }
        if ($expectedExtra !== null //
            && $fieldSchema['extra'] !== $expectedExtra //
        ) {
            throw new \CakeException($errorMessagePrefix . 'extra is ' . $expectedExtra . '.');
        }
    }

    /**
     * Overrides to return single HTML element only.
     *
     * @param string $fieldName This must be 'FieldName' or 'ModelName.FieldName'.
     * @param array  $options   Options. This parameter is called from "\WasaBootstrap3FormHelper" class methods.
     *
     * @return string The single HTML element.
     */
    public function input($fieldName, $options = array ())
    {
        $this->setEntity($fieldName);
        $options = $this->_parseOptions($options);

        // $divOptions = $this->_divOptions($options);
        // unset($options['div']);

        if ($options['type'] === 'radio' && isset($options['options'])) {
            $radioOptions = (array) $options['options'];
            unset($options['options']);
        }

        // $label = $this->_getLabel($fieldName, $options);
        if ($options['type'] !== 'radio') {
            unset($options['label']);
        }

        // $error = $this->_extractOption('error', $options, null);
        // unset($options['error']);
        //
        // $errorMessage = $this->_extractOption('errorMessage', $options, true);
        // unset($options['errorMessage']);

        $selected = $this->_extractOption('selected', $options, null);
        unset($options['selected']);

        if ($options['type'] === 'datetime' || $options['type'] === 'date' || $options['type'] === 'time') {
            $dateFormat = $this->_extractOption('dateFormat', $options, 'MDY');
            $timeFormat = $this->_extractOption('timeFormat', $options, 12);
            unset($options['dateFormat'], $options['timeFormat']);
        }

        $type = $options['type'];
        // $out = array ('before' => $options['before'], 'label' => $label, 'between' => $options['between'], 'after' => $options['after']);
        // $format = $this->_getFormat($options);
        // unset($options['type'], $options['before'], $options['between'], $options['after'], $options['format']);
        unset($options['type']);

        // $out['error'] = null;
        // if ($type !== 'hidden' && $error !== false) {
        //    $errMsg = $this->error($fieldName, $error);
        //    if ($errMsg) {
        //        $divOptions = $this->addClass($divOptions, 'error');
        //        if ($errorMessage) {
        //            $out['error'] = $errMsg;
        //        }
        //    }
        // }
        //
        // if ($type === 'radio' && isset($out['between'])) {
        //    $options['between'] = $out['between'];
        //    $out['between'] = null;
        // }
        // $out['input'] = $this->_getInput(compact('type', 'fieldName', 'options', 'radioOptions', 'selected', 'dateFormat', 'timeFormat'));
        $output = $this->_getInput(compact('type', 'fieldName', 'options', 'radioOptions', 'selected', 'dateFormat', 'timeFormat'));

        // $output = '';
        // foreach ($format as $element) {
        //    $output .= $out[$element];
        // }
        //
        // if (!empty($divOptions['tag'])) {
        //    $tag = $divOptions['tag'];
        //    unset($divOptions['tag']);
        //    $output = $this->Html->tag($tag, $output, $divOptions);
        // }
        return $output;
    }

}
