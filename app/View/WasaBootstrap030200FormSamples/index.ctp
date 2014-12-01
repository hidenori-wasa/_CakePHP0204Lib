<?php
$this->layout = 'WasaBootstrap030200';
$this->set('title_for_layout', 'The Bootstrap form samples.');

use \WasaBootstrap030200FormHelper as WF; // This is this file scope and priority is high.

?>

<!-- Bootstrap's row. -->
<div class="row">
    <!-- Bootstrap's grid system. -->
    <div class="col-md-offset-5 col-md-110">
        <?php
        // Displays the message by Bootstrap's alert if form data was saved to database.
        $savedFormMessage = \CakeSession::read('savedFormMessage');
        if ($savedFormMessage !== null) {
            echo '<div class="alert alert-success">' . $savedFormMessage . '</div>';
        }

        $form = $this->Form;
        // Displays the CSRF token and the form start HTML.
        echo $form->create(
            // The model name.
            'WasaBootstrap030200FormSample', //
            array (
            // Adds Bootstrap's horizontal form class and well class to the form element class attribute.
            'class' => 'form-horizontal well'
            )
        );

        $fieldNames = array ('tel1', 'tel2', 'tel3');
        // Displays it if error.
        $hasErrors = WF::displayErrorWithAlert(array ('fieldNames' => $fieldNames));
        // Displays the telephone text boxes.
        WF::displayTelForGrid120(array (
            'titleColClass' => 'col-sm-40',
            'title' => '電話番号サンプル',
            'contentsColClass' => 'col-sm-80',
            'fieldNames' => $fieldNames,
            'placeholders' => array ('市外局番', '市内局番１', '市内局番２'),
            'hasErrors' => $hasErrors,
        ));

        $fieldNames = array ('checkbox11', 'checkbox12');
        // Displays it if error.
        WF::displayErrorWithAlert(array ('fieldNames' => $fieldNames));
        // Displays checkboxes of rear labels.
        WF::displayCheckboxes(array (
            'titleColClass' => 'col-sm-40',
            'title' => 'Checkboxes sample 1.',
            'contentsColClass' => 'col-sm-80',
            'contentsStyle' => 'padding: 7px 20px 7px 0; font-weight: normal',
            'hoveringBackgroundColor' => 'white',
            'frontMargin' => '4px 10px 0 0',
            'fieldNames' => $fieldNames,
            'values' => array (true, true),
            'labelLocation' => 'rear',
            'labels' => array ('1-1', '1-2'),
            'inlineDisplay' => false
        ));

        $fieldNames = array ('checkbox21', 'checkbox22');
        // Displays it if error.
        WF::displayErrorWithAlert(array ('fieldNames' => $fieldNames));
        // Displays checkboxes of front labels.
        WF::displayCheckboxes(array (
            'titleColClass' => 'col-sm-40',
            'title' => 'Checkboxes sample 2.',
            'contentsColClass' => 'col-sm-80',
            'contentsStyle' => 'padding: 7px 20px 7px 0; font-weight: normal',
            'hoveringBackgroundColor' => 'white',
            'frontMargin' => '4px 10px 0 0',
            'fieldNames' => $fieldNames,
            'values' => array (true, true),
            'labelLocation' => 'front',
            'labels' => array ('1-1', '1-2'),
            'inlineDisplay' => false
        ));

        $fieldNames = array ('checkbox31', 'checkbox32');
        // Displays it if error.
        WF::displayErrorWithAlert(array ('fieldNames' => $fieldNames));
        // Displays inline checkboxes of rear labels.
        WF::displayCheckboxes(array (
            'titleColClass' => 'col-sm-40',
            'title' => 'An inline checkboxes sample 1.',
            'contentsColClass' => 'col-sm-80',
            'contentsStyle' => 'padding: 7px 20px 7px 0; font-weight: normal',
            'hoveringBackgroundColor' => 'white',
            'frontMargin' => '4px 10px 0 0',
            'fieldNames' => $fieldNames,
            'values' => array (true, true),
            'labelLocation' => 'rear',
            'labels' => array ('3-1', '3-2'),
            'inlineDisplay' => true
        ));

        $fieldNames = array ('checkbox41', 'checkbox42');
        // Displays it if error.
        WF::displayErrorWithAlert(array ('fieldNames' => $fieldNames));
        // Displays inline checkboxes of front labels.
        WF::displayCheckboxes(array (
            'titleColClass' => 'col-sm-40',
            'title' => 'An inline checkboxes sample 2.',
            'contentsColClass' => 'col-sm-80',
            'contentsStyle' => 'padding: 7px 20px 7px 0; font-weight: normal',
            'hoveringBackgroundColor' => 'white',
            'frontMargin' => '4px 10px 0 0',
            'fieldNames' => $fieldNames,
            'values' => array (true, true),
            'labelLocation' => 'front',
            'labels' => array ('4-1', '4-2'),
            'inlineDisplay' => true
        ));

        $fieldName = 'radio1';
        // Displays it if error.
        WF::displayErrorWithAlert(array ('fieldNames' => array ($fieldName)));
        // Displays radio buttons of rear labels.
        WF::displayRadioButtons(array (
            'titleColClass' => 'col-sm-40',
            'title' => 'Radio buttons sample 1.',
            'contentsColClass' => 'col-sm-80',
            'contentsStyle' => 'padding: 7px 20px 7px 0; font-weight: normal',
            'hoveringBackgroundColor' => 'white',
            'frontMargin' => '4px 10px 0 0',
            'fieldName' => $fieldName,
            'values' => array (11, 12),
            'labelLocation' => 'rear',
            'labels' => array ('1-1', '1-2'),
            'inlineDisplay' => false
        ));

        $fieldName = 'radio2';
        // Displays it if error.
        WF::displayErrorWithAlert(array ('fieldNames' => array ($fieldName)));
        // Displays radio buttons of front labels.
        WF::displayRadioButtons(array (
            'titleColClass' => 'col-sm-40',
            'title' => 'Radio buttons sample 2.',
            'contentsColClass' => 'col-sm-80',
            'contentsStyle' => 'padding: 7px 20px 7px 0; font-weight: normal',
            'hoveringBackgroundColor' => 'white',
            'frontMargin' => '4px 10px 0 0',
            'fieldName' => $fieldName,
            'values' => array (21, 22),
            'labelLocation' => 'front',
            'labels' => array ('2-1', '2-2'),
            'inlineDisplay' => false
        ));

        $fieldName = 'radio3';
        // Displays it if error.
        WF::displayErrorWithAlert(array ('fieldNames' => array ($fieldName)));
        // Displays inline radio buttons of rear labels.
        WF::displayRadioButtons(array (
            'titleColClass' => 'col-sm-40',
            'title' => 'An inline radio buttons sample 1.',
            'contentsColClass' => 'col-sm-80',
            'contentsStyle' => 'padding: 7px 20px 7px 0; font-weight: normal',
            'hoveringBackgroundColor' => 'white',
            'frontMargin' => '4px 10px 0 0',
            'fieldName' => $fieldName,
            'values' => array (31, 32),
            'labelLocation' => 'rear',
            'labels' => array ('3-1', '3-2'),
            'inlineDisplay' => true
        ));

        $fieldName = 'radio4';
        // Displays it if error.
        WF::displayErrorWithAlert(array ('fieldNames' => array ($fieldName)));
        // Displays inline radio buttons of front labels.
        WF::displayRadioButtons(array (
            'titleColClass' => 'col-sm-40',
            'title' => 'An inline radio buttons sample 2.',
            'contentsColClass' => 'col-sm-80',
            'contentsStyle' => 'padding: 7px 20px 7px 0; font-weight: normal',
            'hoveringBackgroundColor' => 'white',
            'frontMargin' => '4px 10px 0 0',
            'fieldName' => $fieldName,
            'values' => array (41, 42),
            'labelLocation' => 'front',
            'labels' => array ('4-1', '4-2'),
            'inlineDisplay' => true
        ));

        ?>
        <!-- 日付フォームグループ -->
        <div class="form-group">





        </div>
        <div class="col-sm-offset-40">
            <?php
            // ロールオーバー画像ボタン、ＣＳＲＦ対策トークン、フォーム終了のＨＴＭＬを出力する
            echo $form->end(array ('label' => 'WasaBootstrap030200FormSamples/send.png', 'class' => 'wasa-rollover'));

            ?>
        </div>
    </div>
</div>
