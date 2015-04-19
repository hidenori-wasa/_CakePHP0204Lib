/**
 * LICENSE:
 * Copyright (c) 2014-, Hidenori Wasa
 * All rights reserved.
 * @license  http://opensource.org/licenses/mit-license.php  MIT License
 */
function wasaOnResize()
{
}

$(function () {
    $("img.wasa-rollover, input.wasa-rollover").mouseover(function () { // When mouse pointer rides on image.
        $(this).attr("src", $(this).attr("src").replace(/^(.+)(\.[a-z]+)$/, "$1_on$2"));
    }).mouseout(function () { // When mouse pointer gets off image.
        $(this).attr("src", $(this).attr("src").replace(/^(.+)_on(\.[a-z]+)$/, "$1$2"));
    }).each(function () { // Preloads rollover images.
        $("<img>").attr("src", $(this).attr("src").replace(/^(.+)(\.[a-z]+)$/, "$1_on$2"));
    });

    $("form .wasa-data-sync").change(function () {
        var $newVal = $(this).val();
        $("form .wasa-data-sync#" + $(this).attr("id")).each(function () {
            $(this).val($newVal);
        });
    });

    wasaOnResize();
    window.onresize = wasaOnResize;
});
