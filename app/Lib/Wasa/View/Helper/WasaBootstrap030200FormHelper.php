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
use \WasaBootstrap030200FormHelper as WBFH;

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
    /**
     * @const string Inline block style. Width is required because "iOS" or "Android" terminal may need it.
     */
    const INLINE_BLOCK_STYLE = 'position: static !important; display: inline-block !important; width: auto;';

    private static $__form;
    private static $__onceFlag = array ();
    static $titlesColClass;
    static $contentsColClass;

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

        // 入力フォームグループは、form-group ブートストラップクラスで包む
        echo '<div class="form-group">';
        // エラー表示と水平フォーム表示をサポートするためにラベルにブートストラップの control-label クラスを設定する
        echo '<p class="control-label ' . self::$titlesColClass . '"><strong>' . $title . '</strong></p>';
        echo '<div class="' . self::$contentsColClass . ' wasa-form-contents">';

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
            echo '<span class="' . $hasErrors[$fieldName] . '" style="' . WBFH::INLINE_BLOCK_STYLE . ' width: 30%">';
            // 電話番号テキストボックス
            echo $telHTML[$count];
            echo '</span>';
            if ($count === 2) {
                break;
            }
            echo '<span style="' . WBFH::INLINE_BLOCK_STYLE . ' vertical-align: top; margin-top: ' . $separaterMarginTop . ';">―</span>';
        }
        echo '</div>';

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
            echo '<div style="text-align: center">｜</div>';
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
        // The input form group must wrap with bootstrap's "form-group" class.
        echo '<div class="form-group">';
        // Defines bootstrap's "control-label" class to a label for error display and horizontal form display support.
        echo '<p class="control-label ' . self::$titlesColClass . '"><strong>' . $title . '</strong></p>';
        echo '<div class="' . self::$contentsColClass . ' wasa-form-contents">';
        for ($count = 0, $number = count($values); $count < $number; $count++) {
            $fieldName = $fieldNames[$count];
            $value = $values[$count];
            $label = $labels[$count];
            $checkboxElement = self::$__form->input(
                $fieldName, //
                array (
                'type' => 'checkbox',
                'value' => $value,
                'style' => WBFH::INLINE_BLOCK_STYLE,
                )
            );
            preg_match('`<input [[:space:]]+ type [[:space:]]* = [[:space:]]* "checkbox" .* [[:space:]]+ id [[:space:]]* = [[:space:]]* "(.*)"`xXU', $checkboxElement, $matches);
            $id = $matches[1];

            echo '<label class="' . $class . '" for="' . $id . '" style="' . $contentsStyle . '">';
            if ($labelLocation === 'front') {
                // Displays the front label.
                echo '<span class="wasa-label" style="' . WBFH::INLINE_BLOCK_STYLE . '">' . $label . '</span>';
                // Displays checkbox and keeps input value.
                echo $checkboxElement;
            } else {
                // Displays checkbox and keeps input value.
                echo $checkboxElement;
                // Displays the rear label.
                echo '<span class="wasa-label" style="' . WBFH::INLINE_BLOCK_STYLE . '">' . $label . '</span>';
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
        foreach ($values as $value) {
            $values2[$value] = null;
        }
        $inputElementStr = self::$__form->input(
            $fieldName, //
            array (
            'type' => 'radio',
            'style' => WBFH::INLINE_BLOCK_STYLE,
            'options' => $values2,
            'legend' => false,
            'label' => false
            )
        );
        preg_match_all('`<input [[:space:]]+ type [[:space:]]* = [[:space:]]* "hidden".*/>`xXUs', $inputElementStr, $hiddenElements);
        preg_match_all('`<input [[:space:]]+ type [[:space:]]* = [[:space:]]* "radio".*/>`xXUs', $inputElementStr, $radioElements);
        $radioElements = $radioElements[0];

        // The input form group must wrap with bootstrap's "form-group" class.
        echo '<div class="form-group">';
        // Defines bootstrap's "control-label" class to a label for error display and horizontal form display support.
        echo '<p class="control-label ' . self::$titlesColClass . '"><strong>' . $title . '</strong></p>';
        echo '<div class="' . self::$contentsColClass . ' wasa-form-contents">';
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
                echo '<span class="wasa-label" style="' . WBFH::INLINE_BLOCK_STYLE . '">' . $label . '</span>';
                // Displays radio button and keeps input value.
                echo $radioElement;
            } else {
                // Displays radio button and keeps input value.
                echo $radioElement;
                // Displays the rear label.
                echo '<span class="wasa-label" style="' . WBFH::INLINE_BLOCK_STYLE . '">' . $label . '</span>';
            }
            echo '</label>';
        }
        echo '</div>';
        echo '</div>';
    }

    /**
     * 年月日セレクトボックスを表示する
     *
     * @param array $params パラメータの連想配列
     *
     * @return void
     * @link http://localhost/_WasaManual/CakePHP0204.html#WasaBootstrap030200FormHelper-displayDateForJP
     */
    static function displayDateForJP($params)
    {
        extract($params);

        // デバッグ時、データベーステーブルスキーマ "`< fieldName >` date NOT NULL" をチェックする
        self::$__form->checkSchema($fieldName, 'date', false);
        // 入力フォームグループは、form-group ブートストラップクラスで包む
        echo '<div class="form-group">';
        // エラー表示と水平フォーム表示をサポートするためにラベルにブートストラップの control-label クラスを設定する
        echo '<p class="control-label ' . self::$titlesColClass . '"><strong>' . $title . '</strong></p>';
        echo '<div class="' . self::$contentsColClass . ' wasa-form-contents">';

        // 日付セレクトボックスの入力値を保持する設定をし、その HTML を取得する
        $dateHTML = self::$__form->input(
            // フィールド名
            $fieldName,
            // 属性
            array (
            // 日付入力フォーム
            'type' => 'date',
            // 年月日フォーマット
            'dateFormat' => 'YMD',
            'minYear' => $minYear,
            'maxYear' => $maxYear,
            // 月を数値で表示する
            'monthNames' => false,
            // 入力フォームにはブートストラップの form-control クラスを設定し、
            // それぞれの画面サイズで別々のレイアウトで表示するので、複数の同じ入力コントロールのデータを同期させる必要がある為、wasa-data-sync クラスを設定する
            'class' => 'form-control wasa-data-sync',
            )
        );
        // CakePHP が生成したＨＴＭＬから年月日セレクトボックス部分を抽出する
        preg_match_all('`( <select [[:space:]] .* </select [[:space:]]? > )`xXUs', $dateHTML, $matches);
        $yearHTML = $matches[1][0];
        $monthHTML = $matches[1][1];
        $dayHTML = $matches[1][2];
        $centerBlockStyle = "text-align: center";

        // 画面サイズがエキストラスモール以外の場合のレイアウト
        echo '<div style="padding: 0;" class="hidden-xs">';
        // echo '<div style="padding: 0;">'; // For debug.
        echo '<span style="' . WBFH::INLINE_BLOCK_STYLE . '">' . $yearHTML . '</span>';
        echo '<span style="' . WBFH::INLINE_BLOCK_STYLE . '">年</span>';
        echo '<span style="' . WBFH::INLINE_BLOCK_STYLE . '">' . $monthHTML . '</span>';
        echo '<span style="' . WBFH::INLINE_BLOCK_STYLE . '">月</span>';
        echo '<span style="' . WBFH::INLINE_BLOCK_STYLE . '">' . $dayHTML . '</span>';
        echo '<span style="' . WBFH::INLINE_BLOCK_STYLE . '">日</span>';
        echo '</div>';

        // 画面サイズがエキストラスモールの場合のレイアウト
        echo '<div style="padding: 0;" class="visible-xs">';
        // echo '<div style="padding: 0;">'; // For debug.
        echo '<span style="' . WBFH::INLINE_BLOCK_STYLE . ' width: 90%">';
        echo $yearHTML;
        echo '</span>';
        echo '<span style="' . WBFH::INLINE_BLOCK_STYLE . ' margin-top: 0;">年</span>';
        echo '<div style="' . $centerBlockStyle . '">｜</div>';
        echo '<span style="' . WBFH::INLINE_BLOCK_STYLE . ' width: 90%">';
        echo $monthHTML;
        echo '</span>';
        echo '<span style="' . WBFH::INLINE_BLOCK_STYLE . ' margin-top: 0;">月</span>';
        echo '<div style="' . $centerBlockStyle . '">｜</div>';
        echo '<span style="' . WBFH::INLINE_BLOCK_STYLE . ' width: 90%">';
        echo $dayHTML;
        echo '</span>';
        echo '<span style="' . WBFH::INLINE_BLOCK_STYLE . ' margin-top: 0;">日</span>';
        echo '</div>';

        echo '</div>';
        echo '</div>';
    }

}
