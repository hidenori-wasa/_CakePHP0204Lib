<?php
$this->layout = 'WasaBootstrap3.default';
$this->set('title_for_layout', 'The Bootstrap form samples.');

use \WasaBootstrap3FormHelper as WF; // This is this file scope and priority is high.

// Loads form's CSS.
//echo $this->Html->css('/WasaBootstrap3/css/WasaBootstrap3FormHelperA');
echo $this->Html->css('WasaBootstrap3.WasaBootstrap3FormHelperA');
//echo $this->fetch('css');
// Sets columns width.
WF::$titlesColClass = 'col-sm-50';
WF::$contentsColClass = 'col-sm-70';

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
            'WasaBootstrap3.WasaBootstrap3FormSample', //
            array (
            // Adds Bootstrap's horizontal form class and well class to the form element class attribute.
            'class' => 'form-horizontal well'
            )
        );

        $fieldNames = array ('tel1', 'tel2', 'tel3');
        // エラーならば表示する
        $hasErrors = WF::displayErrorWithAlert(array ('fieldNames' => $fieldNames));
        // 電話用のタイトルとテキストコントロールを３つ表示する
        WF::displayTelForJP(array (
            'title' => '電話番号',
            'placeholders' => array ('市外局番', '市内局番', '加入者番号'),
            'hasErrors' => $hasErrors,
            'validation' => array (
                $fieldNames[0] => array (
                    'rule' => array ('phone', '`^ 0 [[:digit:]]{1,4} $`xX'),
                    'message' => '市外局番が間違っています。',
                // 'allowEmpty' => true,
                ),
                $fieldNames[1] => array (
                    'rule' => array ('phone', '`^ [[:digit:]]{1,4} $`xX'),
                    'message' => '市内局番が間違っています。',
                // 'allowEmpty' => true,
                ),
                $fieldNames[2] => array (
                    'rule' => array ('phone', '`^ [[:digit:]]{4} $`xX'),
                    'message' => '加入者番号が間違っています。',
                // 'allowEmpty' => true,
                ),
            ),
        ));

        $fieldNames = array ('checkbox11', 'checkbox12');
        // Displays it if error.
        WF::displayErrorWithAlert(array ('fieldNames' => $fieldNames));
        // Displays checkboxes of rear labels.
        WF::displayCheckboxes(array (
            'title' => 'Checkboxes sample 1.',
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
            'title' => 'Checkboxes sample 2.',
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
            'title' => 'An inline checkboxes sample 1.',
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
            'title' => 'An inline checkboxes sample 2.',
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
            'title' => 'Radio buttons sample 1.',
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
            'title' => 'Radio buttons sample 2.',
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
            'title' => 'An inline radio buttons sample 1.',
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
            'title' => 'An inline radio buttons sample 2.',
            'fieldName' => $fieldName,
            'values' => array (41, 42),
            'labelLocation' => 'front',
            'labels' => array ('4-1', '4-2'),
            'inlineDisplay' => true
        ));

        // 年月日セレクトボックスを表示する
        WF::displayDateForJP(array (
            'title' => '日付',
            'fieldName' => 'date',
            'minYear' => 2050,
            'maxYear' => 2050,
        ));

        $fieldName = 'email';
        // Displays it if error.
        $hasErrors = WF::displayErrorWithAlert(array ('fieldNames' => array ($fieldName)));
        // Displays text box for email.
        WF::displayEmail(array (
            'title' => 'Email',
            'placeholder' => 'Email address.',
            'hasErrors' => $hasErrors,
            'validation' => array (
                $fieldName => array (
                    array (
                        // 'rule' => array ('email', true, WF::generateEmailRegularExpression()),
                        'rule' => array ('email', false, WF::generateEmailRegularExpression()),
                        'message' => 'Mail address is mistaken.',
                    ),
                    array (
                        'rule' => array ('custom', '`.{3,' . WF::EMAIL_ADDR_MAX_LEN . '}`xX'),
                        'message' => 'Mail address is too long.',
                    ),
                ),
            ),
        ));

        // 郵便番号用のタイトルとテキストコントロールを２つ表示する
        //
        // \WasaCache::readArray($form->defaultModel); // For debug. (Autodetection.)
        //
        // Ends the cache writing.
        \WasaCache::writeArray($form->defaultModel);

        // \WasaCache::writeArray($form->defaultModel); // For debug. (Autodetection.)
        // \WasaCache::addArray($form->defaultModel, array('dummy')); // For debug. (Autodetection.)

        ?>
        <div class="col-sm-offset-50">
            <?php
            // Displays rollover image button, token for CSRF and form ending HTML.
            echo $form->end(array ('label' => '/WasaBootstrap3/img/send.png', 'class' => 'wasa-rollover'));

            ?>
        </div>
    </div>
</div>
