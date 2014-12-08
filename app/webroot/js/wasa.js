/**
 * LICENSE:
 * Copyright (c) 2014, Hidenori Wasa
 * All rights reserved.
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD 2-Clause
 */
function wasaOnResize()
{
    var $leftMargin;

    $(".wasa-center-block").each(function () {
        $(this).css("margin-left", "0px");
        $(this).css("display", "inline");
        $leftMargin = $(this).width() / -2;
        $(this).css("display", "block");
        $leftMargin += $(this).width() / 2;
        $(this).css("margin-left", $leftMargin + "px");
    });
}

$(function () {
    $("img.wasa-rollover, input.wasa-rollover").mouseover(function () { // When mouse pointer rides on image.
        $(this).attr("src", $(this).attr("src").replace(/^(.+)(\.[a-z]+)$/, "$1_on$2"));
    }).mouseout(function () { // When mouse pointer gets off image.
        $(this).attr("src", $(this).attr("src").replace(/^(.+)_on(\.[a-z]+)$/, "$1$2"));
    }).each(function () { // Preloads rollover images.
        $("<img>").attr("src", $(this).attr("src").replace(/^(.+)(\.[a-z]+)$/, "$1_on$2"));
    });

    $(".wasa-data-sync").change(function () {
        var $newVal = $(this).val();
        $(".wasa-data-sync#" + $(this).attr("id")).each(function () {
            $(this).val($newVal);
        });
    });

    wasaOnResize();
    window.onresize = wasaOnResize;
});
