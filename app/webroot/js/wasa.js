$(function () {
    $("img.wasa-rollover, input.wasa-rollover").mouseover(function () { // When mouse pointer rides on image.
        $(this).attr("src", $(this).attr("src").replace(/^(.+)(\.[a-z]+)$/, "$1_on$2"));
    }).mouseout(function () { // When mouse pointer gets off image.
        $(this).attr("src", $(this).attr("src").replace(/^(.+)_on(\.[a-z]+)$/, "$1$2"));
    }).each(function () { // Preloads rollover images.
        $("<img>").attr("src", $(this).attr("src").replace(/^(.+)(\.[a-z]+)$/, "$1_on$2"));
    });
});
