<?php

/**
 * Customized form helper.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @category  DUMMY
 * @package   DUMMY
 * @author    CakePHP(tm) <dummy@dummy.com>
 * @copyright 2005-2014 Copyright (c) , Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @version   2.4.9
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     CakePHP(tm) v 0.2.9
 */
\App::uses('FormHelper', 'View/Helper');
\App::uses('WasaBootstrap030200FormHelper', 'View/Helper');
/**
 * Customized form helper.
 *
 * @category  DUMMY
 * @package   DUMMY
 * @author    CakePHP(tm) <dummy@dummy.com>
 * @copyright 2005-2014 Copyright (c) , Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @version   2.4.9
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     CakePHP(tm) v 0.2.9
 */
final class WasaFormHelper extends \FormHelper
{

    /**
     * Sets the debug's level.
     *
     * @param View  $View     Same as parent.
     * @param array $settings Same as parent.
     *
     * @author Hidenori Wasa <public@hidenori-wasa.com>
     */
    public function __construct(View $View, $settings = array ())
    {
        \WasaBootstrap030200FormHelper::construct($this);

        parent::__construct($View, $settings);
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
    public function checkSchema($fieldName, $expectedFieldType, $expectedByteSize = null, $doesNullAllow = null, $expectedDefaultValue = null, $expectedKeyType = null, $expectedExtra = null)
    {
        $modelName = $this->defaultModel;
        if (WASA_DEBUG_LEVEL === 0 // If production.
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
     * @param array  $options   Options. This parameter is called from "\WasaBootstrap030200FormHelper" class methods.
     *
     * @return string The single HTML element.
     * @throws \CakeException
     * @author Hidenori Wasa <public@hidenori-wasa.com>
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
