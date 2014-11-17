<?php

/**
 * Statical bootstrap3 form helper class.
 *
 * CakePHP = 2.4.x
 * Bootstrap = 3.2.0
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
 * @category CakePHP_Library_Of_Wasa
 * @package  DUMMY
 * @author   Hidenori Wasa <public@hidenori-wasa.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD 2-Clause
 * @link     https://github.com/hidenori-wasa/CakePHP0204Lib/
 */
/**
 * The form helper for bootstrap3.
 *
 * @category CakePHP_Library_Of_Wasa
 * @package  DUMMY
 * @author   Hidenori Wasa <public@hidenori-wasa.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD 2-Clause
 * @version  Draft: 1.0.0
 * @link     https://github.com/hidenori-wasa/CakePHP0204Lib/
 */
final class WasaBootstrap030200FormHelper
{
    private static $__form;
    private static $__onceFlag = array ();

    /**
     * Registers the form helper instance to static property.
     *
     * @param object $form The form helper instance.
     *
     * @return void
     * @author Hidenori Wasa <public@hidenori-wasa.com>
     */
    static function construct($form)
    {
        self::$__form = $form;
    }

    /**
     * Displays error with alert bootstrap class.
     *
     * @param array $params Parameter's association array.
     *
     * @return array "Bootstrap's 'has-error' class" of each field name key.
     * @link http://localhost/WasaManual/index.php#WasaBootstrap030200FormHelper-displayErrorWithAlert-
     * @author Hidenori Wasa <public@hidenori-wasa.com>
     */
    static function displayErrorWithAlert($params)
    {
        extract($params);

        foreach ($fieldNames as $fieldName) {
            $error = self::$__form->error($fieldName);
            $hasErrors[$fieldName] = '';
            // If error.
            if ($error !== null) {
                // Displays error with alert bootstrap class.
                echo '<div class="alert alert-danger">' . $error . '</div>';
                // Sets 'has-error' value to change entry form to error color.
                $hasErrors[$fieldName] = 'has-error';
            }
        }

        return $hasErrors;
    }

    /**
     * Displays checkboxes.
     *
     * @param array $params Parameter's association array.
     *
     * @return void
     * @link http://localhost/WasaManual/index.php#WasaBootstrap030200FormHelper-displayCheckboxes-
     * @author Hidenori Wasa <public@hidenori-wasa.com>
     */
    static function displayCheckboxes($params)
    {
        extract($params);

        if (!isset(self::$__onceFlag[__FUNCTION__])) {
            self::$__onceFlag[__FUNCTION__] = true;
            echo <<<EOD
<style type="text/css">
    .checkbox-inline:hover, .checkbox:hover{
        background-color: $hoveringBackgroundColor;
    }
    .form-horizontal .checkbox-inline , .checkbox-inline + .checkbox-inline {
        padding: 0;
        margin: 0;
    }
</style>
EOD;
        }
        if ($inlineDisplay) {
            $class = 'checkbox-inline';
        } else {
            $class = 'checkbox';
        }

        echo '<div class="form-group">';
        // Defines bootstrap's "control-label" class to a label for error display and horizontal form display support.
        echo '<p class="control-label ' . $titleColClass . '"><strong>' . $title . '</strong></p>';
        echo '<div class="' . $contentsColClass . '">';
        for ($count = 0, $number = count($values); $count < $number; $count++) {
            $fieldName = $fieldNames[$count];
            $id = self::$__form->defaultModel . \Inflector::camelize($fieldName);
            $value = $values[$count];
            $label = $labels[$count];

            echo '<label class="' . $class . '" for="' . $id . '" style="' . $contentsStyle . '">';
            if ($labelLocation === 'front') {
                // Displays the front label.
                echo '<span style="position: static; margin: ' . $frontMargin . '">' . $label . '</span>';
                // Displays checkbox and keeps input value.
                $style = 'position: static; margin: 0';
                echo self::$__form->input(
                    $fieldName, //
                    array (
                    'type' => 'checkbox',
                    'value' => $value,
                    'id' => $id,
                    'style' => $style,
                    )
                );
            } else {
                // Displays checkbox and keeps input value.
                $style = 'position: static; margin: ' . $frontMargin;
                echo self::$__form->input(
                    $fieldName, //
                    array (
                    'type' => 'checkbox',
                    'value' => $value,
                    'id' => $id,
                    'style' => $style,
                    )
                );
                // Displays the rear label.
                echo $label;
            }
            echo '</label>';
        }
        echo '</div>';
        echo '</div>';
    }

    /**
     * Displays radio buttons.
     *
     * @param array $params Parameter's association array.
     *
     * @return void
     * @link http://localhost/WasaManual/index.php#WasaBootstrap030200FormHelper-displayRadioButtons-
     * @author Hidenori Wasa <public@hidenori-wasa.com>
     */
    static function displayRadioButtons($params)
    {
        extract($params);

        if (!isset(self::$__onceFlag[__FUNCTION__])) {
            self::$__onceFlag[__FUNCTION__] = true;
            echo <<<EOD
<style type="text/css">
    .radio-inline:hover, .radio:hover{
        background-color: $hoveringBackgroundColor;
    }
    .form-horizontal .radio-inline , .radio-inline + .radio-inline {
        padding: 0;
        margin: 0;
    }
</style>
EOD;
        }
        if ($inlineDisplay) {
            $class = 'radio-inline';
        } else {
            $class = 'radio';
        }
        if ($labelLocation === 'front') {
            $style = 'position: static; margin: 0';
        } else {
            $style = 'position: static; margin: ' . $frontMargin;
        }
        foreach ($values as $value) {
            $values2[$value] = null;
        }
        $inputElementStr = self::$__form->input(
            $fieldName, //
            array (
            'type' => 'radio',
            'style' => $style,
            'options' => $values2,
            'legend' => false,
            'label' => false
            )
        );
        preg_match_all('`<input type="hidden".*/>`XU', $inputElementStr, $hiddenElements);
        preg_match_all('`<input type="radio".*/>`XU', $inputElementStr, $radioElements);
        $radioElements = $radioElements[0];

        echo '<div class="form-group">';
        // Defines bootstrap's "control-label" class to a label for error display and horizontal form display support.
        echo '<p class="control-label ' . $titleColClass . '"><strong>' . $title . '</strong></p>';
        echo '<div class="' . $contentsColClass . '">';
        if (array_key_exists(0, $hiddenElements)) {
            $hiddenElements = $hiddenElements[0];
            foreach ($hiddenElements as $hiddenElement) {
                echo $hiddenElement;
            }
        }
        for ($count = 0, $number = count($values); $count < $number; $count++) {
            list($modelName, $fieldName) = explode('.', self::$__form->_entityPath);
            $id = $modelName . \Inflector::camelize($fieldName) . $values[$count];
            $label = $labels[$count];

            echo '<label class="' . $class . '" for="' . $id . '" style="' . $contentsStyle . '">';
            if ($labelLocation === 'front') {
                // Displays the front label.
                echo '<span style="position: static; margin: ' . $frontMargin . '">' . $label . '</span>';
                // Displays radio button and keeps input value.
                echo $radioElements[$count];
            } else {
                // Displays radio button and keeps input value.
                echo $radioElements[$count];
                // Displays the rear label.
                echo $label;
            }
            echo '</label>';
        }
        echo '</div>';
        echo '</div>';
    }

}
