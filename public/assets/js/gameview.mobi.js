
// Initialisation UI
$(document).ready(function() {
    var objwidth = $('article.game').first().outerWidth(true);
    var section = $('.main_container > section');
    var section_real_width = parseInt(section.width() / objwidth) * objwidth;
    section.css({
        'width': section_real_width,
        'left': (section.width() - section_real_width) / 2
    });
});