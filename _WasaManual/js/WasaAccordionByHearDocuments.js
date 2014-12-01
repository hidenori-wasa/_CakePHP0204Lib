/**
 * LICENSE:
 * Copyright (c) 2014, Hidenori Wasa
 * All rights reserved.
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD 2-Clause
 */

$(function () {
    try {
        $codes = new Array();
        $urlHashFragments = new Array();
        $('textarea.wasa-hear-document').each(function () {
            var $id;
            $id = $(this).attr('id');
            $urlHashFragments.push($id);
            $codes[$id] = $(this).text();
        });
        $urlHashFragments = $urlHashFragments.sort();
        for ($count = 0, $number = $urlHashFragments.length; $count < $number; $count++) {
            $urlHashFragment = $urlHashFragments[$count];
            $code = $codes[$urlHashFragment].replace(/</g, '&lt;');
            $code = $code.replace(/>/g, '&gt;');
            $('#wasa-accordion').append(" \
<div class=\"panel panel-default\"> \
    <div class=\"panel-heading\"> \
        <div class=\"panel-title\"> \
            <a data-toggle=\"collapse\" data-parent=\"#wasa-accordion\" data-target=\"#" + $urlHashFragment + "\" name=\"" + $urlHashFragment + "\"> \
                \\" + $urlHashFragment + "() \
            </a> \
        </div> \
    </div> \
    <div id=\"" + $urlHashFragment + "\" class=\"panel-collapse collapse\"> \
        <div class=\"panel-body\"> \
            <pre><code>" + $code + "</code></pre> \
        </div> \
    </div> \
</div>");
            // Searches URL hash-fragments. And, displays its code.
            $urlHashFragment = '#' + $urlHashFragment;
            $pattern = $urlHashFragment + '$';
            if (document.URL.match(new RegExp($pattern)) !== null) {
                $($urlHashFragment).addClass('in');
                // Scrolls until title.
                $('html,body').animate({scrollTop: $($urlHashFragment).offset().top - 40}, 'slow');
            }
        }
    } catch (e) {
        alert(" \
NAME: " + e.name + "\n \
MESSAGE: " + e.message + "\n \
FILE: " + e.fileName + "\n \
LINE: " + e.lineNumber + "\n \
STACK: " + e.stack);
    }
});
