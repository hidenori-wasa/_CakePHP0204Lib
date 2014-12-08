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
 * @category DUMMY
 * @package  DUMMY
 * @author   Hidenori Wasa <public@hidenori-wasa.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD 2-Clause
 * @link     https://github.com/hidenori-wasa/_CakePHP0204Lib/
 */
/**
 * The form helper for bootstrap3.
 *
 * @category DUMMY
 * @package  DUMMY
 * @author   Hidenori Wasa <public@hidenori-wasa.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD 2-Clause
 * @version  Draft: 1.0.0
 * @link     https://github.com/hidenori-wasa/_CakePHP0204Lib/
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
     * @link http://localhost/_WasaManual/CakePHP0204.html#WasaBootstrap030200FormHelper-displayErrorWithAlert
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

//    /**
//     * Displays the telephone text boxes.
//     *
//     * @param array $params Parameter's association array.
//     *
//     * @return void
//     * @link http://localhost/_WasaManual/CakePHP0204.html#WasaBootstrap030200FormHelper-displayTelForGrid120-JP
//     */
//    static function displayTelForGrid120($params)
//    {
//        extract($params);
//
//        echo '<div class="form-group">';
//        // Defines bootstrap's "control-label" class to a label for error display and horizontal form display support.
//        echo '<p class="control-label ' . $titleColClass . '"><strong>' . $title . '</strong></p>';
//        echo '<div class="' . $contentsColClass . '">';
//        for ($count = 0;; $count++) {
//            $fieldName = $fieldNames[$count];
//            $placeholder = $placeholders[$count];
//            // エラーの場合、入力フォームをエラー色にする
//            echo '<div style="padding: 0;" class="col-sm-34 ' . $hasErrors[$fieldName] . '">';
//            // tel テキストボックス、入力値を保持する
//            echo self::$__form->input(
//                // フィールド名
//                $fieldName,
//                // 属性
//                array (
//                // 電話入力フォーム
//                'type' => 'tel',
//                //'type' => 'text',
//                // 入力フォームに初期表示する説明文字列
//                'placeholder' => $placeholder,
//                // 入力フォームには Bootstrap の form-control クラスを定義する
//                'class' => 'form-control',
//                )
//            );
//            echo '</div>';
//            if ($count === 2) {
//                break;
//            }
//            // 横幅によってグリッド間隔が変化しないように small medium large それぞれのグリッド幅を設定する
//            echo '<div class="col-sm-6 col-md-5 col-lg-4" style="padding: 5px 0 0 5px;">―</div>';
//        }
//        echo '</div>';
//        echo '</div>';
//    }

    /**
     * 電話用のタイトルとテキストコントロールを３つ表示する
     *
     * @param array $params パラメータの連想配列
     *
     * @return void
     * @link http://localhost/_WasaManual/CakePHP0204.html#WasaBootstrap030200FormHelper-displayTelForJP
     */
    static function displayTelForJP($params)
    {
        extract($params);

        echo '<div class="form-group">';
        // エラー表示と水平フォーム表示をサポートするためにラベルにブートストラップの control-label クラスを設定する
        echo '<p class="control-label ' . $titleColClass . '"><strong>' . $title . '</strong></p>';
        echo '<div class="' . $contentsColClass . '">';

        for ($count = 0; $count < 3; $count++) {
            $fieldName = $fieldNames[$count];
            $placeholder = $placeholders[$count];
            // 電話番号テキストボックスの入力値を保持する設定をし、その HTML を取得する
            $telHTML[$count] = self::$__form->input(
                // フィールド名
                $fieldName,
                // 属性
                array (
                // 電話入力フォーム
                'type' => 'tel',
                // 入力フォームに初期表示する説明文字列
                'placeholder' => $placeholder,
                // 入力フォームにはブートストラップの form-control クラスを設定し、
                // それぞれの画面サイズで別々のレイアウトで表示するので、複数の同じ入力コントロールのデータを同期させる必要がある為、wasa-data-sync クラスを設定する
                'class' => 'form-control wasa-data-sync',
                )
            );
        }

        echo '<div style="padding: 0;" class="hidden-xs">';
        // echo '<div style="padding: 0;">'; // For debug.
        for ($count = 0;; $count++) {
            $fieldName = $fieldNames[$count];
            // エラーの場合、入力フォームをエラー色にする
            echo '<div class="' . $hasErrors[$fieldName] . '" style="float: left; width: 30%">';
            // 電話番号テキストボックス
            echo $telHTML[$count];
            echo '</div>';
            if ($count === 2) {
                break;
            }
            echo '<span style="float: left; margin-top: 4px;">―</span>';
        }
        echo '</div>';
        echo '<div class="clearfix"></div>';

        echo '<div style="padding: 0;" class="visible-xs">';
        // echo '<div style="padding: 0;">'; // For debug.
        for ($count = 0;; $count++) {
            $fieldName = $fieldNames[$count];
            // エラーの場合、入力フォームをエラー色にする
            echo '<div class="' . $hasErrors[$fieldName] . '">';
            // 電話番号テキストボックス
            echo $telHTML[$count];
            echo '</div>';
            if ($count === 2) {
                break;
            }
            echo '<div class="wasa-center-block">｜</div>';
        }
        echo '</div>';

        echo '</div>';
        echo '</div>';
    }

    /**
     * Displays checkboxes.
     *
     * @param array $params Parameter's association array.
     *
     * @return void
     * @link http://localhost/_WasaManual/CakePHP0204.html#WasaBootstrap030200FormHelper-displayCheckboxes
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
            $value = $values[$count];
            $label = $labels[$count];

            if ($labelLocation === 'front') {
                $style = 'position: static; margin: 0';
            } else {
                $style = 'position: static; margin: ' . $frontMargin;
            }
            $checkboxElement = self::$__form->input(
                $fieldName, //
                array (
                'type' => 'checkbox',
                'value' => $value,
                'style' => $style,
                )
            );
            $id = preg_replace('`^.*<input type="checkbox".* id="(.*)".*$`XU', '$1', $checkboxElement);

            echo '<label class="' . $class . '" for="' . $id . '" style="' . $contentsStyle . '">';
            if ($labelLocation === 'front') {
                // Displays the front label.
                echo '<span style="position: static; margin: ' . $frontMargin . '">' . $label . '</span>';
                // Displays checkbox and keeps input value.
                echo $checkboxElement;
            } else {
                // Displays checkbox and keeps input value.
                echo $checkboxElement;
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
     * @link http://localhost/_WasaManual/CakePHP0204.html#WasaBootstrap030200FormHelper-displayRadioButtons
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
            $radioElement = $radioElements[$count];
            $id = preg_replace('`^.* id="(.*)".*$`XU', '$1', $radioElement);
            $label = $labels[$count];

            echo '<label class="' . $class . '" for="' . $id . '" style="' . $contentsStyle . '">';
            if ($labelLocation === 'front') {
                // Displays the front label.
                echo '<span style="position: static; margin: ' . $frontMargin . '">' . $label . '</span>';
                // Displays radio button and keeps input value.
                echo $radioElement;
            } else {
                // Displays radio button and keeps input value.
                echo $radioElement;
                // Displays the rear label.
                echo $label;
            }
            echo '</label>';
        }
        echo '</div>';
        echo '</div>';
    }

}
